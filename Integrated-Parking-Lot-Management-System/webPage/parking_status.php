<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>한성주차통합서비스</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">한성 주차통합서비스</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample05">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.html">홈</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="parking_status.php">주차현황</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="client_info_main.html">내 차량</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_main.html">관리자</a>
          </li>
        </ul>
        </li>
        </ul>

      </div>
    </div>
  </nav>


  <main>
    <div id="mid" class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center">
      <div class="col-md-5 p-lg-5 mx-auto my-5">
        <?php
        //mysql 접속
        $host = "localhost";
        $user = "user1";
        $pw = "1771356";
        $dbName = "testtest";
        $mysql = new mysqli($host, $user, $pw, $dbName);
        //camera_space 테이블에 있는 데이터를 주차자리 순으로 정렬하여 쿼리
        $query = "select * from camera_space order by 주차자리 desc";
        $rs = mysqli_query($mysql, $query);
        ?>
        <br>
        <h1 class="display-3 text-center">주차 자리</h1>
        <br>
        <!--테이블-->
        <table class="table table-striped text-nowrap table-bordered">
          <thead>
            <tr>
              <th scope="col" class=" text-center h3">A6</th>
              <th scope="col" class=" text-center h3">A5</th>
              <th scope="col" class=" text-center h3">A4</th>
              <th scope="col" class=" text-center h3">A3</th>
              <th scope="col" class=" text-center h3">A2</th>
              <th scope="col" class=" text-center h3">A1</th>
            </tr>
          </thead>
          <tbody>
            <!--쿼리한 테이블은 주차자리 순으로 레코드를 불러오고, 주차여부는 1과 0으로 저장되어있음-->
            <tr height="75px">
              <?php
              while ($board = mysqli_fetch_array($rs)) {
                //주차가 되어있다면 1이 저장되어있으므로 주차를 할수있는 자리가 없으므로 빨간색 배경의 X를 보여줌
                if ($board['주차여부'])
                  echo '<td class="table-danger text-center align-middle h1">' . "X" . "</td>";
                else
                  //주차가 되어있지 않다면 0이 저장되어있으므로 else로 넘어가고 파란 배경의 O를 보여줌
                  echo '<td class ="table-primary text-center align-middle h1">' . "O" . "</td>";
              }
              ?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
