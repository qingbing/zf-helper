# 版本提示
- 1.0.3
    - 修改 replace 函数bug
    - 修改 链路ID为 trace_id 标识符
- 1.0.4
    - 添加 openssl密码管理封装类
- 1.0.5
    - 将 Register 修改成 DataStore
- 1.0.6
    - 增加 DataStore 获取的时的存储功能
    - 修改 trace-id 的获取的存储方式
    - 删除 ID::uniqid(), 附加到 Util::uniqid()
    - 添加 CustomException 异常
    - 添加 ip段验证
- 1.0.7
    - 添加 ExcelHelper 用于 excel 的导出
- 1.0.8
    - 修改 ExcelHelper 下载时，字符数字小数后末尾为零的展示bug,eg: 5.00 的显示
- 1.0.9
    - ExcelHelper 添加硬盘保存 save 和 读取 readFile 功能
- 1.0.10
    - ExcelHelper 修复身份证号和浮点数展示转文本的问题
    - 增加 Math 数据函数助手
    - 增加 is_real_array 函数，判断是否为真实的数字索引数组
    - 修改 \Zf\Helper\Timer::begin 方法，支持标记事件刷新和保持功能
    - 增加 \Zf\Helper\Business\DeepTree 类，解决id、pid之类二维数组的树形结构构造
    - 增加片段 TOptionFormat，前端选项的格式化
    - 增加 \Zf\Helper\NumericTransform 进制数转换工具
- 1.0.11
    - 增加"对比关系"片段 \Zf\Helper\Traits\Models\TLabelCompareRelation
    - 增加"排序"片段 \Zf\Helper\Traits\Models\TLabelOrderBy
    - 在function中加入函数 is_url
    - 增加 \Zf\Helper\Business\IpHelper::inRanges, 判断ip是否在多组ip范围内
    - 增加 \Zf\Helper\Abstracts\TreeData:数组转换为树形结构基类
    - 增加 \Zf\Helper\Business\ObjectTree 类，解决id、pid之类二维数组的树形结构构造
    - 将 \Zf\Helper\Util::randomString, 改成掩码模式
- 1.0.12
    - 增加 UnsupportedException 异常处理
    - \Zf\Helper\Business\ExcelHelper 增加多sheet和对齐格式支持
- ??
    - \Zf\Helper\Exceptions\NotFoundHttpException 增加不存在异常
    - 增加Unicode编码转换: \Zf\Helper\Transfor\UnicodeHelper
    - 增加标点符号转换: \Zf\Helper\Transfor\SymbolHelper
    - 增加任意进制数转化十进制数: \Zf\Helper\Transfor\NumberHelper::baseToDec
    - function中加入方法to_array
    - 加入一些header常量


# zf-helper
常用的方法和函数，多为静态类，抽象类，接口类等

# 文档
1. [常规常量定义 ： constant](doc/constant.md)
1. [常用函数封装 ： functions](doc/functions.md)

## 抽象类
1. [抽象类基类 ： Base](doc/helpers/Abstracts/Base.md)
1. [自定义组件基类 ： Component](doc/helpers/Abstracts/Component.md)
1. [工厂模式基类 ： Factory](doc/helpers/Abstracts/Factory.md)
1. [单例模式基类 ： Singleton](doc/helpers/Abstracts/Singleton.md)
1. [数组转换为树形结构基类 ： TreeData](doc/helpers/Abstracts/TreeData.md)

## 业务类
1. [时间段获取 ： DateRange](doc/helpers/Business/DateRange.md)
1. [array-deep实现的 pid-id 树形结构构造 ： DeepTree](doc/helpers/Business/DeepTree.md)
1. [文件下载类 ： Download](doc/helpers/Business/Download.md)
1. [excel装填下载 ： ExcelHelper](doc/helpers/Business/ExcelHelper.md)
1. [Ip 地址助手 ： IpHelper](doc/helpers/Business/IpHelper.md)
1. [Object实现的 pid-id 树形结构构造 ： ObjectTree](doc/helpers/Business/ObjectTree.md)
1. [行政区划管理 ： Region](doc/helpers/Business/Region.md)


## 加密类
1. [openssl密码管理封装 ： Openssl](doc/helpers/Crypt/Openssl.md)


## 异常类定义
1. [业务异常 ： BusinessException](doc/helpers/Exceptions/BusinessException.md)
1. [coding类异常 ： ClassException](doc/helpers/Exceptions/ClassException.md)
1. [用户自定义异常 ： CustomException](doc/helpers/Exceptions/CustomException.md)
1. [异常基类 ： Exception](doc/helpers/Exceptions/Exception.md)
1. [访问禁用异常 ： ForbiddenHttpException](doc/helpers/Exceptions/ForbiddenHttpException.md)
1. [http 异常 ： HttpException](doc/helpers/Exceptions/HttpException.md)
1. [不存在界面异常 ： NotFoundHttpException](doc/helpers/Exceptions/NotFoundHttpException.md)
1. [coding参数异常 ： ParameterException](doc/helpers/Exceptions/ParameterException.md)
1. [程序异常 ： ProgramException](doc/helpers/Exceptions/ProgramException.md)
1. [coding属性异常 ： PropertyException](doc/helpers/Exceptions/PropertyException.md)
1. [运行时异常 ： RuntimeException](doc/helpers/Exceptions/RuntimeException.md)
1. [不支持的业务异常 ： UnsupportedException](doc/helpers/Exceptions/UnsupportedException.md)

## 身份辅助类
1. [身份证号解析 ： IdentityParser](doc/helpers/Identity/IdentityParser.md)


## 迭代类
1. [List迭代器 ： ListIterator](doc/helpers/Iterators/ListIterator.md)
1. [Map迭代器 ： MapIterator](doc/helpers/Iterators/MapIterator.md)


## 插件（需要配置属性）
1. [无状态的json-web-token ： Jwt](doc/helpers/Plugins/Jwt.md)

### 加密类
1. [base64对数据加密 ： Base64](doc/helpers/Plugins/Crypt/Base64.md)
1. [openssl加密和解密封装 ： Openssl](doc/helpers/Plugins/Crypt/Openssl.md)


## Trait片段
1. [为$this对象的属性赋值 ： TConfigure](doc/helpers/Traits/TConfigure.md)
1. [格式化前端选项 ： TOptionFormat](doc/helpers/Traits/TOptionFormat.md)
1. [属性判断和处理 ： TProperty](doc/helpers/Traits/TProperty.md)


### 模型辅助类
1. ["对比关系"标签 ： TLabelCompareRelation](doc/helpers/Traits/Models/TLabelCompareRelation.md)
1. ["删除状态"标签 ： TLabelDeleted](doc/helpers/Traits/Models/TLabelDeleted.md)
1. ["启用状态"标签 ： TLabelEnable](doc/helpers/Traits/Models/TLabelEnable.md)
1. ["禁用状态"标签 ： TLabelForbidden](doc/helpers/Traits/Models/TLabelForbidden.md)
1. ["排序"标签 ： TLabelOrderBy](doc/helpers/Traits/Models/TLabelOrderBy.md)
1. ["性别"标签 ： TLabelSex](doc/helpers/Traits/Models/TLabelSex.md)
1. ["是/否"标签 ： TLabelYesNo](doc/helpers/Traits/Models/TLabelYesNo.md)

## 数据转换类
1. [Ascii码转换 ： AsciiHelper](doc/helpers/Transfor/AsciiHelper.md)
1. [数据进制转化 ： NumberHelper](doc/helpers/Transfor/NumberHelper.md)
1. [标点符号转换 ： SymbolHelper](doc/helpers/Transfor/SymbolHelper.md)
1. [Unicode编码转换 ： UnicodeHelper](doc/helpers/Transfor/UnicodeHelper.md)

## 其它助手类
1. [文件目录处理 ： FileHelper](doc/helpers/FileHelper.md)
1. [常用格式化 ： Format](doc/helpers/Format.md)
1. [数学函数 ： Math](doc/helpers/Math.md)
1. [Ob缓冲管理 ： ObBuffer](doc/helpers/ObBuffer.md)
1. [类或Object处理 ： Obj](doc/helpers/Obj.md)
1. [数据存储 ： DataStore](doc/helpers/DataStore.md)
1. [请求获取类 ： ReqHelper](doc/helpers/ReqHelper.md)
1. [记时器 ： Timer](doc/helpers/Timer.md)
1. [功能集合 ： Util](doc/helpers/Util.md)
1. [列表，提供push，pop，unshift，shift等操作 ： ZList](doc/helpers/ZList.md)
1. [Map，提供add,get,remove,clear,count等操作 ： ZMap](doc/helpers/ZMap.md)


# ====== 组件编号 101 ======
# 异常文件编号
1. 1010001 : \Zf\Helper\Traits\TProperty
2. 1010002 : \Zf\Helper\ZList
3. 1010003 : \Zf\Helper\ZMap
4. 1010004 : \Zf\Helper\Obj
5. 1010005 : \Zf\Helper\Timer
6. 1010006 : \Zf\Helper\FileHelper
7. 1010007 : \Zf\Helper\Business\Download
8. 1010008 : \Zf\Helper\Business\DateRange
9. 1010009 : \Zf\Helper\Identity\IdentityParser
10. 1010010 : \Zf\Helper\Crypt\Openssl


