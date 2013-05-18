<?php

if (isset($_POST['Submit']))
{
    $isError = false;

    //Validate empty strings
    $isError = $isError || ValidateNotEmpty('txtName', 'שם');
    $isError = $isError || ValidateNotEmpty('txtMail', 'כתובת מייל');
    $isError = $isError || ValidateNotEmpty('txtTitle', 'כותרת');
    $isError = $isError || ValidateNotEmpty('txtContent', 'תוכן ההודעה');
    $isError = $isError || ValidateNotEmpty('txtResult', 'סכום');

    //Validate mail
    if ($_POST['txtMail'] != "")
    {
        if (!filter_var($_POST['txtMail'], FILTER_VALIDATE_EMAIL))
        {
            //$_POST['txtMailError'] .=
        }
    } else {
        $errors .= 'Please enter your email address.<br/>';
    }
}

function ValidateNotEmpty($pFieldName, $pFieldHebName)
{
    $isError = false;
    $_POST[$pFieldName."Error"] = "";
    if ($_POST[$pFieldName] == "")
    {
        $_POST[$pFieldName."Error"] .= "השדה '".$pFieldHebName."' הוא שדה חובה";
        $isError = true;
        return $isError;
    }

    if ($_POST[$pFieldName] != filter_var($_POST[$pFieldName], FILTER_SANITIZE_STRING))
    {
        $_POST[$pFieldName."Error"] .= "השדה '".$pFieldHebName."' מכיל תווים לא חוקיים";
        $isError = true;
    }

    return $isError;
}
