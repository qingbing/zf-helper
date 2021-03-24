
# 片段 TConfigure : 为$this对象的属性赋值
```php
class demo
{
    use TConfigure;
    protected $name;
    public    $sex;
    private   $age;
}


$demo = new demo();
$demo->configure([
    'name' => 'qingbing',
    'sex'  => 'nan',
    'age'  => 18,
]);
var_dump($demo);
/*
 * ===== output start ======
object(app\controllers\demo)#77 (3) {
  ["name":protected]=>
  string(8) "qingbing"
  ["sex"]=>
  string(3) "nan"
  ["age":"app\controllers\demo":private]=>
  int(18)
}
 * ===== output end ======
 */
```
