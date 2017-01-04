<?php
            $editRow = null;
            $deleteRow = null;
            $tempArray = array();
            $tempArray = json_decode(file_get_contents('test.json'), true);
            //Add
            if (isset($_POST['btn_send'])) {
                if (($_POST['money'] >= 5000000) && ($_POST['age'] >= 15)) {
                    $tempArray[] = $_POST;
                    file_put_contents('test.json', json_encode($tempArray));
                }
            }
            
            // Sort
            if (count($tempArray) > 1) {
                for ($i = 0; $i < count($tempArray) - 1; $i++) {
                    for ($j = $i + 1; $j < count($tempArray); $j++) {
                        if ($tempArray[$i]['money'] < $tempArray[$j]['money']) {
                            $temp = $tempArray[$i];
                            $tempArray[$i] = $tempArray[$j];
                            $tempArray[$j] = $temp;
                        }
                    }
                }
            }
            
            //Update
            if (isset($_POST['btn_update']) && isset($_GET['index'])){
                if (($_POST['money'] >= 5000000) && ($_POST['age'] >= 15)) {
                    $idx = $_GET['index'];
                    $tempArray[$idx] = $_POST;
                    file_put_contents('test.json', json_encode($tempArray));
                    if (count($tempArray) > 1) {
                        for ($i = 0; $i < count($tempArray) - 1; $i++) {
                            for ($j = $i + 1; $j < count($tempArray); $j++) {
                                if ($tempArray[$i]['money'] < $tempArray[$j]['money']) {
                                    $temp = $tempArray[$i];
                                    $tempArray[$i] = $tempArray[$j];
                                    $tempArray[$j] = $temp;
                                }
                            }
                        }
                    }
                }
            }

            // Edit
            if (isset($_GET['action']) && isset($_GET['index'])){
                $idx = $_GET['index'];
                if ($_GET['action'] == 'edit'){
                    $editRow = $tempArray[$idx];
                }
                if ($_GET['action'] == 'delete'){
                    unset($tempArray[$idx]);
                    $rs = array();
                    foreach ($tempArray as $item) {
                        $rs[] = $item;
                    }
                    file_put_contents('test.json', json_encode($rs));
                    header('Location: http://localhost/BaitapPHP/index.php');
                    exit();
                }
            }
            
            // Search
            if (isset($_POST['btn_search'])){
                $search = $_POST['search'];
                foreach ($tempArray as $key){
                    if($key == $search){
                        
                    }
                }        
            }
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
        <style>
            tr,th,td{
                border: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <div>
            <?php
            if (isset($_POST['btn'])) {
                $a = $_POST['numbera'];
                $b = $_POST['numberb'];
                $c = $_POST['numberc'];
                $delta = ($b * $b) - (4 * $a * $c);
                if ($delta < 0) {
                    echo "Phương trình vô nghiệm";
                } else if ($delta == 0) {
                    echo "Phương trình có 1 nghiệm là: " . (-$b / (2 * $a));
                } else if ($delta > 0) {
                    echo "Phương trình có 2 nghiệm phân biệt là: " . "<br/>" . "x1 = " . ((-$b - sqrt($delta)) / (2 * $a)) . "<br/>"
                    . "x2 = " . ((-$b + sqrt($delta)) / (2 * $a));
                }
            }
            ?>
        </div>
        <form action="index.php" method="post">
            <p>Phương trình bậc 2 có dạng: ax^2 + bx + c = 0</p>
            Số a: <input type="text" name="numbera"/> <br/>
            Số b: <input type="text" name="numberb"/> <br/>
            Số c: <input type="text" name="numberc"/> <br/>
            <input type="submit" value="Giải" name="btn" />
        </form><br/>
        <?php if ($editRow == null) { ?>
            <h2> Add New Account </h2>
        <?php } else { ?>
            <h2> Update Account </h2>
        <?php } ?>
        <form action="index.php<?php echo isset($_GET['index']) ? '?index=' . $_GET['index'] :  ''; ?>"  method="post">  
            Mã: <input type="text" name="id" class="id" id="id" 
                    value="<?php if (isset($editRow['id'])) { echo $editRow['id'];} ?>"/> <br/>
            Tên: <input type="text" name="name" class="name" id="name"
                    value="<?php if (isset($editRow['name'])) { echo $editRow['name'];} ?>"/> <br/>
            Tuổi: <input type="text" name="age" class="age" id="age"
                    value="<?php if (isset($editRow['age'])) { echo $editRow['age'];} ?>"/> <br/>
            STK: <input type="text" name="stk" class="stk" id="stk"
                    value="<?php if (isset($editRow['stk'])) { echo $editRow['stk'];} ?>"/> <br/>
            Số tiền: <input type="text" name="money" class="money" id="money"
                    value="<?php if (isset($editRow['money'])) { echo $editRow['money'];} ?>"/> <br/>
            <?php if ($editRow == null) { ?>
                <input type="submit" value="Nhập" name="btn_send"/><br/>
            <?php } else { ?>
                <input type="submit" value="Sửa" name="btn_update"/><br/>
            <?php } ?>
            <input type="submit" value="Search" name="btn_search"/><br/>
            <input type="text" name="search" placeholder="Search by No." />
            <input type="submit" value="Reset" name="btn_reset"/><br/>
        </form>
        <table boder="1">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>STK</th>
                    <th>Money</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($tempArray)) : ?>
                    <?php if (count($tempArray) >= 0) { ?>
                        <?php foreach ($tempArray as $key => $item) { ?>
                            <?php if (isset($_POST['btn_search'])) { ?>
                                <?php if ($key == $search && $search != '') { ?>
                                    <tr>
                                        <td><?= ($key) ?></td>
                                        <td><?= $item['id'] ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['age'] ?></td>
                                        <td><?= $item['stk'] ?></td>
                                        <td><?= number_format($item['money']) ?></td>
                                        <td><a href="index.php?action=edit&index=<?= ($key) ?>">Edit</a></td>
                                        <td><a href="index.php?action=delete&index=<?= ($key) ?>">Delete</a></td>
                                    </tr>
                                <?php } else if(isset($_POST['btn_reset'])) { ?>
                                    <tr>
                                        <td><?= ($key) ?></td>
                                        <td><?= $item['id'] ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['age'] ?></td>
                                        <td><?= $item['stk'] ?></td>
                                        <td><?= number_format($item['money']) ?></td>
                                        <td><a href="index.php?action=edit&index=<?= ($key) ?>">Edit</a></td>
                                        <td><a href="index.php?action=delete&index=<?= ($key) ?>">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>   
                                    <tr>
                                        <td><?= ($key) ?></td>
                                        <td><?= $item['id'] ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['age'] ?></td>
                                        <td><?= $item['stk'] ?></td>
                                        <td><?= number_format($item['money']) ?></td>
                                        <td><a href="index.php?action=edit&index=<?= ($key) ?>">Edit</a></td>
                                        <td><a href="index.php?action=delete&index=<?= ($key) ?>">Delete</a></td>
                                    </tr>
                            <?php } ?>
                        <?php } ?>  
                    <?php } ?>
                <?php endif; ?>      
            </tbody>
    </table>

</body>
</html>
