<?php
// URL to list of CSV Shortlinks
$URLToCSV="https://raw.githubusercontent.com/hyphacoop/shortlinks/master/shortlinks.csv";

// Enable caching of file by defining the number of minutes the file is considered stale
// 0 = disables caching
$cacheInterval=15;

$forceRefresh=0;
if (isset($_REQUEST['force'])) $forceRefresh = 1;
// Path to the file where the caching will be stored
// File must be writable
// Hint: chown www-data.www-data shortlinks.csv 
$cacheFile=dirname(__FILE__) . "/shortlinks.csv";

$MSG="";
$link = $_REQUEST['link'];

$tolink = "";

if ($cacheInterval || $forceRefresh) { 
    if (is_writable($cacheFile)) {
        if (time()-filemtime($filename) > $cacheInterval * 60) {
            $csv = file_get_contents($URLToCSV);
            file_put_contents($cacheFile,$csv);
        } else {
            $csv = file_get_contents($cacheFile);
        }
    } else {
        $csv = file_get_contents($URLToCSV);
        $MSG="Cannot Write To $cacheFile<br>";
    }
} else {
    $csv = file_get_contents($URLToCSV);
}


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
else
    $msg = "<span class='error'>There is no <b>$link</b> defined as a short link.</span>";

if ($link == "redit.php" || $link == "" ) $link = $msg = "";

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
            padding:0;
            margin:0;
            display: table;
        }
        h1 {
            font-size:42px;
            margin:0px;
            padding:0px;
        }
        .Selection {
            text-align: center;
            font-size: 24px;
            display: table-cell;
            vertical-align: middle;
            height:100%;
        }

        .Selection input {
            padding: 10px;
            font-size: 24px;
        }

        .autocomplete-suggestions {
            background: white;
            border: 1px solid black;
            color: black;
            overflow: auto;
        }

        .autocomplete-suggestion {
            padding: 2px;
            color:#999999;
        }

        .autocomplete-suggestion:hover {
            background: #e3c9f4;
        }

        .autocomplete-suggestion strong {
            color: #9900fc;
        }
        .error {
            background:white;
            color:red;
            display:inline-block;
            padding:5px;
            border-radius:3px;
        }
    </style>
    <div class="Selection">
        <h1>HYPHA</h1>
        <label for="files">Short Link Redirector</label>
        <br/>
        <br/>
        <?=$msg?>
        <br/>
        Enter short link
        <br/>
        <input type="text" name="code" id="autocomplete" value="<?= $link ?>" />
        <center><?=$MSG?></center>
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
