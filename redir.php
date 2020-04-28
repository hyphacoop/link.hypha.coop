<?php

$link = $_REQUEST['link'];
if ($link == "redit.php") $link = "";

$tolink = "";
$csv = file_get_contents("https://raw.githubusercontent.com/hyphacoop/shortlinks/master/shortlinks.csv");

$lines = explode("\n", $csv);
foreach ($lines as $line) {
    $val = explode(",", $line);
    if (strtolower($link) == strtolower($val[0])) {
        $tolink = $val[1];
        break;
    }
}

if ($tolink != "")
    header("location: $tolink");
?>
<html>

<head>
    <title>Hypha Link Redirector</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.2.27/jquery.autocomplete.min.js"></script>
</head>

<body>
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            background: #9900fc;
            color: white;
            font-family: 'WorkSans', helvetica, sans-serif;
        }

        .Selection {
            text-align: center;
            font-size: 24px;
        }

        .Selection input {
            padding: 10px;
        }

        .autocomplete-suggestions {
            background: white;
            border: 1px solid black;
            color: black;
            overflow: auto;
        }

        .autocomplete-suggestion {
            padding: 2px;

        }

        .autocomplete-suggestion:hover {
            background: #e3c9f4;
        }

        .autocomplete-suggestion strong {
            color: #9900fc;
            font-weight: normal;
        }
    </style>
    <div class="Selection">
        <strong>HYPHA<br></strong>
        <label for="files">Enter Short Link</label><br>
        <input type="text" name="code" id="autocomplete" value="<?= $link ?>" />
    </div>
    <script>
        var options = [
            <?php
            foreach ($lines as $line) {
                $val = explode(",", $line);
                echo "    { value: '$val[0]', data: '$val[1]' },";
            }
            ?> {
                value: '',
                data: ''
            }
        ];
        $('#autocomplete').autocomplete({
            lookup: options,
            onSelect: function(suggestion) {
                window.location = suggestion.data;
            }
        });
    </script>
</body>
</html>
