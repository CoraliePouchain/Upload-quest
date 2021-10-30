<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . uniqid() . basename($_FILES['avatar']['name']);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $extension_ok = ['jpg', 'webp', 'png', 'gif'];
    $maxFileSize = 1048576;

    $errors = [];
    $data = array_map('trim', $_POST);

    if((!in_array($extension, $extension_ok ))) {
        $errors[]= 'Veuillez sélectionner une image de type Jpg, Png, Wepb ou Gif';
    }
    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[]= 'Votre fichier doit faire moins de 1Mo';
    }
    if(empty($data['firstname'])) {
        $errors[]= 'Firstname is requested'; 
    }
    if(strlen($data['firstname'] > 100)) {
        $errors[]= 'Firstame is too long';
    }
    if(empty($data['lastname'])) {
        $errors[]= 'Lastname is requested'; 
    }
    if(strlen($data['lastname'] > 100)) {
        $errors[]= 'Lastname is too long';
    }
    if(empty($data['age'])) {
        $errors[]= 'Age is requested'; 
    }
    if(($data['age'] > 100 )) {
        $errors[]= 'You\'re not immortal dude';
    }
    if(empty($errors)) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile); 
    } else {
        foreach($errors as $error){
            echo $error . '<br>';
        }
    }
    if(isset($_POST['delete'])) {
        if(file_exists($uploadFile)){
            unlink($uploadFile);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action='' method='post' enctype='multipart/form-data'>
        <label for='imageUpload'>Upload a profile image</label>    
        <input type='file' name='avatar' id='imageUpload' />

        <label for='firstname'>Firstname</label>
        <input type='text' name='firstname' id='firstname'>

        <label for='lastname'>Lastname</label>
        <input type='text' name='lastname' id='lastname'>

        <label for='age'>Age</label>
        <input type='number' name='age' id='age'><br>

        <button name='send'>Send</button>

        <button name='delete'>Delete</button>

    </form>
    
    <?php foreach($_POST as $post) : ?>
            <p><?= $post ?></p>
        <?php endforeach; ?>

    <?= '<img src=' . $uploadFile . '/>' ?>

</body>
</html>
