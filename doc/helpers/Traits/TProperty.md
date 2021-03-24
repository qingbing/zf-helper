# 片段 TProperty : 属性判断和处理
```php

{
    use TProperty;
    private $_name;
    private $_sex;

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name): void
    {
        $this->_name = $name;
    }

    public function setSex($sex): void
    {
        $this->_sex = $sex;
    }
}


$demo = new demo();

$demo->name = "qingbing"; // 由 __set(string $property, $value) 调用 setName("qingbing")
var_dump($demo->name); // 由 __get(string $property) 调用 getName()

var_dump(isset($demo->name)); // 由 __isset(string $property): bool 调用 (getName() !== NULL)
unset($demo->name); // 由 __unset(string $property) 调用 setName(NULL)

var_dump($demo->canGetProperty('sex')); // 判断是否存在getter函数 getSex()
var_dump($demo->canSetProperty('sex')); // 判断是否存在setter函数 setSex()
var_dump($demo->hasProperty('sex')); // 判断是否存在getter 或 setter函数

```
