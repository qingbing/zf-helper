# 片段 TOptionFormat : 格式化前端选项

- 格式化选项输出 : protected function optionFormat(array $data, $idField = 'id', string $valueField = 'value', $type = OPTION_TYPE_OBJECT)
    - $data 为类似 db-select 的二维数据
    - 支持的 $type 目前为两种
        - object（OPTION_TYPE_OBJECT） ： 对象模式
        - id-value（OPTION_TYPE_ID_VALUE） ： id-value模式
