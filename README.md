# Anagram Finder Web Application

## Overview

The Anagram Finder is a web application that allows users to:
1. Upload a dictionary file and find the word with the most anagrams from that file.
2. Enter a word to find its anagrams from the uploaded file.

The application uses PHP for server-side processing and JavaScript for client-side validation.

## Features

- **File Input**: Users can specify a dictionary file by entering its name.
- **Anagram Search**: After uploading the file, users can search for anagrams of a specific word.
- **Validation**: Ensures that users enter a file name before finding anagrams and validates that a word is entered before searching.

## Installation

1. **Prerequisites**:
   - A web server with PHP support (e.g., Apache, Nginx).
   - Basic knowledge of web server setup.

2. **Directory Structure**:
   - Place the `index.php` file in your web server's root directory.
   - Create a `dictionaries` directory to store the dictionary files.

3. **Deploy**:
   - Upload the `index.php` file and the `dictionaries` folder to your web server.
   - Ensure that the `dictionaries` folder is writable and accessible.

## Usage

1. **Access the Application**:
   - Open a web browser and navigate to the URL where `index.php` is hosted.

2. **Upload and Process File**:
   - Enter the name of the dictionary file in the "File Name" input field.
   - Click the "Find Word with Most Anagrams" button to process the file and find the word with the most anagrams.

3. **Find Anagrams**:
   - Once a file is processed, enter a word in the "Or, enter a word to find its anagrams" input field.
   - Click the "Find Anagrams" button to see the results.

4. **Error Handling**:
   - If the file name is not entered and you try to find the word with the most anagrams, an alert will prompt you to enter a file name.
   - If the word field is empty and you try to find anagrams, an alert will prompt you to enter a word.

## Code Overview

### `index.php`

- **PHP Code**:
  - Handles file processing and searches for the word with the most anagrams.
  - Finds anagrams of a specific word from the uploaded file.

- **JavaScript Code**:
  - Validates the form submission to ensure that the appropriate fields are filled before submission.

### JavaScript Validation

The script ensures:
- **File Input**: Prompts users to enter a file name if they attempt to find the word with the most anagrams without a file.
- **Word Input**: Prompts users to enter a word if they attempt to find anagrams without specifying a word.

Here’s the JavaScript snippet used for validation:

```javascript
document.getElementById('anagramForm').addEventListener('submit', function(event) {
    const findMostAnagramsBtn = event.submitter.name === 'findMostAnagrams';
    const inputWordField = document.getElementById('inputWord');
    const fileNameField = document.getElementById('fileName');

    if (findMostAnagramsBtn) {
        if (!fileNameField.value.trim()) {
            alert('Please enter the file name.');
            event.preventDefault(); // Prevent form submission
            return;
        }
    } else {
        if (!inputWordField.value.trim()) {
            alert('Please enter a word to find anagrams.');
            event.preventDefault(); // Prevent form submission
            return;
        }
    }
});
```

### Example HTML Form

Here’s how the form looks in the application:

```html
<form id="anagramForm" action="" method="post">
    <div class="form-group">
        <label for="fileName">File Name:</label>
        <h2>
            <?php
            if (!empty($fileName)) {
                echo htmlspecialchars(basename($fileName), ENT_QUOTES, 'UTF-8');
            }
            ?>
        </h2>
        <input type="text" name="fileName" id="fileName" value="<?php
            if (!empty($fileName)) {
                echo htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8');
            }
            ?>" placeholder="Enter the file name" required>
    </div>

    <input type="submit" name="findMostAnagrams" value="Find Word with Most Anagrams">

    <div class="form-group"><br>
        <label for="inputWord">Or, enter a word to find its anagrams:</label>
        <input type="text" name="inputWord" id="inputWord" value="<?php
            if (!empty($inputWord)) {
                echo htmlspecialchars($inputWord, ENT_QUOTES, 'UTF-8');
            }
            ?>" placeholder="Enter a word to find anagrams">
    </div>

    <input type="submit" name="findAnagrams" value="Find Anagrams">
</form>

<!-- Results Column -->
<div class="results-container">
    <?php
    // Display results if available
    if (!empty($results)) {
        echo $results;
    }
    ?>
</div>
```

## Troubleshooting

- **File Not Found Error**: Verify that the file name is correct and that the file exists in the `dictionaries` folder.
- **Validation Issues**: Ensure JavaScript is enabled in your browser. Check for errors in the browser's developer console if validation fails.
---
