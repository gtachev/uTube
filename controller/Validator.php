<?php

namespace controller;


class Validator
{
    private static $instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Validator();
        }
        return self::$instance;
    }

    /*
     * validate data presence
     * uses trim() so empty spaces don't count
     * uses === to avoid false positives
     * better than empty() which considers "0" to be empty
     */
    private function isBlank($value) {
        if (!isset($value) || trim($value) === '') {
            return true;
        }
        return false;
    }

    /*
     * validate string length
     * spaces count towards length
     * so using trim() to remove them
     */
    private function hasLengthGreaterThan($value, $min) {
        $length = trim(strlen($value));
        return $length >= $min;
    }

    private function hasSpecialChars($value) {
        if (preg_match('/[-!$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/', $value)) {
            return true;
        }
        return false;
    }

    /*
     * validate string length
     * spaces count towards length
     * so using trim() to remove them
     */
    private function hasLengthLessThan($value, $max) {
    $length = trim(strlen($value));
    return $length <= $max;
    }

    /*
     * validate if string contains whitespace
     */
    private function containsSpace($value) {
        if (preg_match('/\s/',$value)) {
            return true;
        }
        return false;
    }

    private function hasValidEmail($email) {
      /*
       * valid format
       * [chars]@[chars].[2+ letters]
       */
        $emailRegex = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';
        return preg_match($emailRegex, $email) === 1;
    }

    private function hasValidPassword($pass) {
        /*
         * checks for at least 1 digit, lowercase and uppercase letter; also for length of minimum 6
         */
        $passRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!$%@#£€*?&]{6,}$/';
        return preg_match($passRegex, $pass) === 1;
    }

    private function hasValidFileSize($file, $allowedSize) {
        return filesize($file) <= $allowedSize;
    }

    private function hasValidMimeType($file, $mimeType) {
        $fileMimeType = explode('/', mime_content_type($file))[0];
        return $mimeType === $fileMimeType;
    }

    private function hasValidExtension($file, array $allowedExt) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        return in_array($extension, $allowedExt);
    }

    public function validateUsername($username) {
        $errors = array();
        if ($this->isBlank($username)) {
            $errors[] = 'Username cannot be blank.';
        }
        if ($this->containsSpace($username)) {
            $errors[] = 'Username cannot contain whitespace.';
        }
        if ($this->hasSpecialChars($username)) {
            $errors[] = 'Username cannot special characters.';
        }
        if (!($this->hasLengthLessThan($username, 20))) {
            $errors[] = 'Username cannot contain more than 20 characters.';
        }
        if (!($this->hasLengthGreaterThan($username, 5))) {
            $errors[] = 'Username must be at least 5 characters long.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validateEmail($email) {
        $errors = array();
        if ($this->isBlank($email)) {
            $errors[] = 'Email cannot be blank.';
        }
        if ($this->containsSpace($email)) {
            $errors[] = 'Email cannot contain whitespace.';
        }
        if (!($this->hasLengthGreaterThan($email, 6))) {
            $errors[] = 'Email must be at least 6 characters long.';
        }
        if (!($this->hasValidEmail($email))) {
            $errors[] = 'Email format is not valid.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validateFirstName($firstName) {
        $errors = array();
        if ($this->isBlank($firstName)) {
            $errors[] = 'First name cannot be blank.';
        }
        if ($this->containsSpace($firstName)) {
            $errors[] = 'First name cannot contain whitespace.';
        }
        if ($this->hasSpecialChars($firstName)) {
            $errors[] = 'First name cannot special characters.';
        }
        if (!($this->hasLengthLessThan($firstName, 20))) {
            $errors[] = 'First name cannot contain more than 20 characters.';
        }
        if (!($this->hasLengthGreaterThan($firstName, 2))) {
            $errors[] = 'First name must be at least 2 characters long.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validateLastName($lastName)
    {
        $errors = array();
        if ($this->isBlank($lastName)) {
            $errors[] = 'Last name cannot be blank.';
        }
        if ($this->containsSpace($lastName)) {
            $errors[] = 'Last name cannot contain whitespace.';
        }
        if ($this->hasSpecialChars($lastName)) {
            $errors[] = 'Last name cannot contain special characters.';
        }
        if (!($this->hasLengthLessThan($lastName, 20))) {
            $errors[] = 'Last name cannot contain more than 20 characters.';
        }
        if (!($this->hasLengthGreaterThan($lastName, 2))) {
            $errors[] = 'Last name must be at least 2 characters long.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validatePassword($pass, $confirmPass) {
        $errors = array();
        if (!($this->hasValidPassword($pass))) {
            $errors[] = 'Password should contain at least 1 digit, 1 uppercase and 1 lowercase letters and should be at least 6 characters long.';
        }
        if (!($this->hasLengthLessThan($pass, 20))) {
            $errors[] = 'Password cannot contain more than 20 characters.';
        }
        if ($this->isBlank($confirmPass)) {
            $errors['confirm-pass'] = 'Confirm password cannot be blank.';
        }
        if ($pass !== $confirmPass) {
            $errors[] = 'The passwords do not match.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validateUploadedFile($fileRealName, $fileTmpName, $allowedSize, $mimeType, array $extensions) {
        $errors = array();
        if (!($this->hasValidFileSize($fileTmpName, $allowedSize))) {
            $mb = round($allowedSize  / 1048576);
            $errors[] = "File cannot be larger than $mb megabytes.";
        }
        if (!($this->hasValidMimeType($fileTmpName, $mimeType))) {
            $errors[] = 'The uploaded file must be an image.';
        }
        if (!($this->hasValidExtension($fileRealName, $extensions))) {
            $extensionsString = '';
            foreach ($extensions as $extension) {
                $extensionsString .= ' ' . $extension;
            }
            $errors[] = 'Allowed image types are' . $extensionsString . '.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validateTitle($title) {
        $errors = array();
        if (!($this->hasLengthLessThan($title, 90))) {
            $errors[] = 'Title cannot contain more than 90 characters.';
        }
        if (!($this->hasLengthGreaterThan($title, 5))) {
            $errors[] = 'Title must be at least 5 characters long.';
        }
        if ($this->isBlank($title)) {
            $errors[] = 'Title cannot be blank.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validateDescription($description) {
        $errors = array();
        if (!($this->hasLengthLessThan($description, 350))) {
            $errors[] = 'Description cannot contain more than 350 characters.';
        }
        if (!($this->hasLengthGreaterThan($description, 5))) {
            $errors[] = 'Description must be at least 5 characters long.';
        }
        if ($this->isBlank($description)) {
            $errors[] = 'Description cannot be blank.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function validateUploadedVideo($fileRealName, $fileTmpName, $allowedSize, $mimeType, array $extensions) {
        $errors = array();
        if (!($this->hasValidFileSize($fileTmpName, $allowedSize))) {
            $mb = round($allowedSize  / 1048576);
            $errors[] = "Video cannot be larger than $mb megabytes.";
        }
        if (!($this->hasValidMimeType($fileTmpName, $mimeType))) {
            $errors[] = 'The uploaded file must be a video.';
        }
        if (!($this->hasValidExtension($fileRealName, $extensions))) {
            $extensionsString = '';
            foreach ($extensions as $extension) {
                $extensionsString .= ' ' . $extension;
            }
            $errors[] = 'Allowed video types are' . $extensionsString . '.';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

}