<?php
// заданный массив
$params= array(
    array( 'text' => 'Текст красного'
        , 'cells' => '1,2'
        , 'align' => 'center'
        , 'valign' => 'center'
        , 'color' => 'FF0000'
        , 'bgcolor' => '0000FF')
    , array( 'text' => 'Текст зеленого цвета'
        , 'cells' => '8,9'
        , 'align' => 'right'
        , 'valign' => 'bottom'
        , 'color' => '00FF00'
        , 'bgcolor' => 'FFFFFF'),
    array( 'text' => 'Текст '
        , 'cells' => '3,6'
        , 'align' => 'right'
        , 'valign' => 'bottom'
        , 'color' => 'FF0000'
        , 'bgcolor' => 'FFFFFF'));
?>
<?php
//функция обработки параметров таблицы 
 function generate($params)
{
    $table=array(); 
    for($i=1;$i<=9;++$i)
    {
     $table[$i]=array('col'=>'1','row'=>'1','text'=>'');   
    }    
   //проверка на наличие параметров 
    if(!empty($params))
        {  
        file_put_contents('css.css','');//создает/очищает фаил
        
        foreach ($params as $item)// генерирует $table согласно входным параметрам
            {
            $cells= explode(',',$item['cells']);
            asort($cells);
            $count= count($cells);
            for ($i=0;$i<$count;++$i)
                {
                for($j=$i+1;$j<$count;++$j)
                    {
                     if ($cells[$i]+1==$cells[$j])    
                         {
                        if(isset($table[$cells[$i]])){$table[$cells[$i]]['col']+=1;}
                        unset($table[$cells[$j]]);
                         }   
                     if ($cells[$i]==($cells[$j]-3))
                         {                         
                         if(isset($table[$cells[$i]])){$table[$cells[$i]]['row']+=1;}
                         unset($table[$cells[$j]]);
                         }   
                    }
                }
            if(!empty($item['text'])){$table[$cells['0']]['text']=$item['text'];}
            $class='#cell'.$cells['0'].'{';
            $class.='text-align:'.$item['align'].';';
            $class.='vertical-align:'.$item['valign'].';';
            $class.='color:#'.$item['color'].';';
            $class.='background-color:#'.$item['bgcolor'].';';
            $class.='}';
            file_put_contents('css.css',$class, FILE_APPEND);//запись в фаил
            }
            showPage($table);//отображения страницы
        }
}
?>

 <?php //функция отобаржения страницы
 function showPage($table)
 {?>
 <!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css.css" type="text/css"/>
        <title></title>
    </head>
    <body>
        <table border="1" width="30%" align="center">
            <tr height="100px">
                <?php
                for ($i=1;$i<=9;++$i)
                    {
                        if(isset($table[$i])){echo'<td id="cell'.$i.'" colspan="'.($table[$i]['col']).'"  rowspan="'.($table[$i]['row']).'" >'.$table[$i]['text'].'</td>';}
                        if($i%3==0 && $i!=9){echo '</tr><tr height="100px">';}
                    }
                ?>   
            </tr>
        </table>
    </body>
</html>    
 <?php }?>
 
<?php generate($params);//вызов функции?>