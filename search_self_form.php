<html lang="ja">
    <?php
    $dsn = "mysql:host=localhost; dbname=mydb; charset=utf8";
    $username = "selfusr";
    $password = "1234";

    try {
        $dbh = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $msg = $e->getMessage();
    }
    
    session_start();
    $id= $_SESSION['id'];

    $sql = "SELECT COUNT(*) FROM images";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    
    $sql = "SELECT skn_type FROM images WHERE details_id = '".$id."'";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $type = $stmt->fetchColumn();

    $sql = "SELECT * FROM images WHERE skn_type = '".$type."'";
    $query = $dbh->prepare($sql);
    $query->execute();
    if( $row > 0){
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $comment = $row["comment"]; 
            $imageURL = 'uploads/'.$row["file_name"];
    ?>
        <p><?php echo $comment; ?></p>
        <br>
        <img src="<?php echo $imageURL; ?>" alt="" />
        
    <?php }
    }else{ ?>
       
    <p>画像が見つからず表示されません..</p>
    <?php } ?>
</html>