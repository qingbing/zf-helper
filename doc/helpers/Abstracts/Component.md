# 抽象类 Component : 自定义组件基类

1. 继承了[Base](Base.md)
2. 获取实例 ： {class}::getInstance(array $config = null)
3. 类不能 new
4. 实例不能 clone
5. 子类构造函数直接覆盖 init() 方法即可

```php
class demo extends Component
{
    public  $sex;
    private $_name;

    public function init()
    {
    }

    public function setName($name): void
    {
        $this->_name = $name;
    }
}

$demo = demo::getInstance([
    'name' => "qingbing",
    'sex'  => "nan",
]);
var_dump($demo);
/*
 * ===== output start ======
object(app\controllers\demo)#77 (2) {
  ["sex"]=>
  string(3) "nan"
  ["_name":"app\controllers\demo":private]=>
  string(8) "qingbing"
}
 * ===== output end ======
 */
 
 
$demo = demo::getInstance([
    'name' => "nianyi",
    'sex'  => "nv",
]);
var_dump($demo);
/*
 * ===== output start ======
object(app\controllers\demo)#78 (2) {
  ["sex"]=>
  string(2) "nv"
  ["_name":"app\controllers\demo":private]=>
  string(6) "nianyi"
}
 * ===== output end ======
 */

```
