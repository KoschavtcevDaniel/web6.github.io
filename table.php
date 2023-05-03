<style>
body{
    background-color: aquamarine;
    display: flex;
    justify-content:center;
    margin-top:5%;
    margin-bottom:5%;
}
  .error {
    border: 2px solid red;
  }
  .hidden{
    display: none;
  }
</style>
<body>
  <div class="table1">
    <table border = "1">
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Year</th>
        <th>Sex</th>
        <th>Limbs</th>
        <th>Abilities</th>
        <th>Biography</th>
      </tr>
      <?php
      foreach($users as $user){
          echo '
            <tr>
              <td>'.$user['name'].'</td>
              <td>'.$user['email'].'</td>
              <td>'.$user['year'].'</td>
              <td>'.$user['sex'].'</td>
              <td>'.$user['limbs'].'</td>
              <td>';
                $user_abil=array(
                    "ab_in"=>FALSE,
                    "ab_t"=>FALSE,
                    "ab_l"=>FALSE,
                    "ab_v"=>FALSE,
                );
                foreach($abil as $abl){
                    if($abl['aplication_id']==$user['id']){
                        if($abl['ability']=='ab_in'){
                            $user_abil['ab_in']=TRUE;
                        }
                        if($abl['ability']=='ab_t'){
                            $user_abil['ab_t']=TRUE;
                        }
                        if($abl['ability']=='ab_l'){
                            $user_abil['ab_l']=TRUE;
                        }      
                        if($abl['ability']=='ab_v'){
                          $user_abil['ab_v']=TRUE;
                      }                   
                    }
                }
                if($user_abil['ab_in']){echo 'ab_in<br>';}
                if($user_abil['ab_t']){echo 'ab_t<br>';}
                if($user_abil['ab_l']){echo 'ab_l<br>';}
                if($user_abil['ab_v']){echo 'ab_v<br>';}
              echo '</td>
              <td>'.$user['biography'].'</td>
              <td>
                <form method="get" action="ind.php">
                  <input name=edit_id value='.$user['id'].' hidden>
                  <input type="submit" value=Edit>
                </form>
              </td>
            </tr>';
       }
      ?>
    </table>
    <?php
    printf('Пользователи с невидимость: %d <br>',$abil_count[0]);
    printf('Пользователи с телепортация: %d <br>',$abil_count[1]);
    printf('Пользователи с левитация: %d <br>',$abil_count[2]);
    printf('Пользователи с всезнание: %d <br>',$abil_count[3]);
    ?>
  </div>
</body>