# 抽象类 TreeData ： 数组转换为树形结构基类
- 继承自 [Factory](Factory.md)
- 提供链式设置方法
    - setTopTag($topTag) : 设置数据顶级标识
    - setId($id) : 设置数据ID标识
    - setPid($pid) : 设置parentID数据标识
    - setSourceData(array $data) : 设置原始数据
    - setFilter(?callable $filter) : 设置数据过滤函数
- 获取最终的树形结构数据
    - getTreeData() : 返回树形化的接口数据
- 解析数据抽象方法
    - parseSourceData(): array;

# 使用参考
- [DeepTree](../Business/DeepTree.md)