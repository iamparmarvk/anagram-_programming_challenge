<?php
// Function to find the word with the most anagrams from a file
function getWordsWithMostAnagramsFromFile($fileName)
{
    $wordMap = [];

    // Check if the file exists
    if (!file_exists($fileName)) {
        return "Error: File not found!";
    }

    // Read the file line by line
    $file = fopen($fileName, "r");
    while (($word = fgets($file)) !== false) {
        $word = trim($word);
        $signature = str_split($word);
        sort($signature);
        $signature = implode('', $signature);

        // Populate the hashmap
        if (array_key_exists($signature, $wordMap)) {
            $wordMap[$signature][] = $word;
        } else {
            $wordMap[$signature] = [$word];
        }
    }
    fclose($file);

    // Find the maximum set of anagrams
    $maxAnagrams = [];
    $maxCount = 0;

    foreach ($wordMap as $anagrams) {
        $count = count($anagrams);
        if ($count > $maxCount) {
            $maxCount = $count;
            $maxAnagrams = $anagrams;
        }
    }

    return $maxAnagrams;
}

// Function to find anagrams of a specific word from a file
function findAnagramsOfWord($fileName, $inputWord)
{
    $wordMap = [];

    // Check if the file exists
    if (!file_exists($fileName)) {
        return "Error: File not found!";
    }

    // Generate signature of the input word
    $inputSignature = str_split($inputWord);
    sort($inputSignature);
    $inputSignature = implode('', $inputSignature);

    // Read the file line by line
    $file = fopen($fileName, "r");
    while (($word = fgets($file)) !== false) {
        $word = trim($word);
        $signature = str_split($word);
        sort($signature);
        $signature = implode('', $signature);

        // Populate the hashmap
        if (array_key_exists($signature, $wordMap)) {
            $wordMap[$signature][] = $word;
        } else {
            $wordMap[$signature] = [$word];
        }
    }
    fclose($file);

    // Return anagrams of the input word
    return isset($wordMap[$inputSignature]) ? $wordMap[$inputSignature] : [];
}

// Handle form submission
// PHP logic to handle form submission and display results
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileName = $_POST['fileName'];

    // Initialize an empty variable to store the results
    $results = '';

    if (!empty($_POST['findMostAnagrams'])) {
        $anagrams = getWordsWithMostAnagramsFromFile($fileName);

        if (is_string($anagrams)) {
            // Handle error messages
            $results .= "<h2 class='error-message'>$anagrams</h2>";
        } else {
            // Ensure $anagrams is an array before processing
            if (is_array($anagrams)) {
                $results .= "<h2>Word(s) with the most anagrams:</h2>";
                $results .= "<ul class='anagram-list'>";
                foreach ($anagrams as $word) {
                    $results .= "<li>$word</li>";
                }
                $results .= "</ul>";
                $results .= "<p>Total anagrams: " . count($anagrams) . "</p>";
            } else {
                // Handle unexpected result types
                $results .= "<h2>Unexpected result format for anagrams.</h2>";
            }
        }
    } elseif (!empty($_POST['inputWord'])) {
        $inputWord = $_POST['inputWord'];
        $anagrams = findAnagramsOfWord($fileName, $inputWord);

        if (is_string($anagrams)) {
            // Handle error messages
            $results .= "<h2 class='error-message'>$anagrams</h2>";
        } elseif (empty($anagrams)) {
            $results .= "<h2>No anagrams found for '$inputWord'.</h2>";
        } else {
            // Ensure $anagrams is an array before processing
            if (is_array($anagrams)) {
                $results .= "<h2>Anagrams for '$inputWord':</h2>";
                $results .= "<ul class='anagram-list'>";
                foreach ($anagrams as $word) {
                    $results .= "<li>$word</li>";
                }
                $results .= "</ul>";
                $results .= "<p>Total anagrams: " . count($anagrams) . "</p>";
            } else {
                // Handle unexpected result types
                $results .= "<h2>Unexpected result format for anagrams.</h2>";
            }
        }
    }

    // Output the results
    // echo $results;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anagram Finder - Dolphin Computer Access</title>

    <!-- Meta Description -->
    <meta name="description" content="Anagram Finder by Dolphin Computer Access helps you find anagrams from text files or specific words. An easy and effective tool for text analysis.">

    <!-- Meta Keywords -->
    <meta name="keywords" content="anagram finder, text analysis, Dolphin Computer Access, word solver, anagram tool">

    <!-- Meta Author -->
    <meta name="author" content="Vishal Parmar">

    <!-- Canonical URL -->
    <link rel="canonical" href="javascript:void(0)">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap">

    <!-- Favicon -->
    <link rel="icon" href="javascript:void(0)" type="image/x-icon">

    <!-- Author's Website -->
    <meta name="author" content="Vishal Parmar">
    <link rel="author" href="http://www.parmarvishal.com">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
            margin: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
        }

        .form-container,
        .results-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            width: calc(50% - 20px);
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
            font-size: 2.5rem;
            font-weight: 600;
            font-family: 'Montserrat', sans-serif;
        }

        h2 {
            font-size: 1.5rem;
            color: #333333;
            margin-top: 10px;
            margin-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .error-message {
            color: #dc3545;
            /* Red color for errors */
            font-family: 'Montserrat', sans-serif;
        }

        label {
            font-weight: 500;
            color: #333333;
            display: block;
            margin-bottom: 5px;
            font-family: 'Roboto', sans-serif;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 15px;
            box-sizing: border-box;
            font-size: 1rem;
            font-family: 'Roboto', sans-serif;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 10px;
            transition: background-color 0.3s ease;
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .anagram-list {
            list-style-type: none;
            padding-left: 0;
        }

        .anagram-list li {
            display: inline-block;
            margin-right: 15px;
            font-weight: 600;
            font-family: 'Montserrat', sans-serif;
        }

        @media (max-width: 768px) {

            .form-container,
            .results-container {
                width: 100%;
                /* Full width on smaller screens */
            }

            .anagram-list li {
                display: block;
                /* Stack list items vertically on small screens */
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Form Column -->
        <div class="form-container">
            <h1>Anagram Finder</h1>
            <form id="anagramForm" action="" method="post">
                <div class="form-group">
                    <label for="fileName">File Name:</label>
                    <h2>
                        <?php
                        if (!empty($fileName)) {
                            echo htmlspecialchars(basename($fileName), ENT_QUOTES, 'UTF-8');
                        }
                        ?></h2>
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

        </div>

        <!-- Results Column -->
        <div class="results-container">
            <?php
            // Display results if available
            if (!empty($results)) {
                echo $results;
            }
            ?>
        </div>
    </div>
    <script>
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
    </script>
</body>
</html>