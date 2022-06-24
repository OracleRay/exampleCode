<?php
namespace lib;

//分页类
//显示样式：当前为 1/7 [首页] [上一页] [下一页] 尾页
class Page
{
    private $total;       // 总共的记录数
    private $pagesize;    // 每页显示的条数
    private $current;     // 当前页
    private $pagenum;     // 总的页数
    /**
     * 分页类构造方法
     * @param int $total    总记录数
     * @param int $pagesize 每页显示的条数
     * @param int $current  当前页
     */
    public function __construct($total, $pagesize, $current)
    {
        $this->total = $total;
        $this->pagesize = $pagesize;
        $this->current = $current;
        $this->pagenum = ceil($this->total / $this->pagesize);
    }
    //获取SQL中的limit条件
    public function getLimit()
    {
        //计算limit条件
        $lim = ($this->current -1) * $this->pagesize;
        return $lim.','.$this->pagesize;
    }
    //获得URL参数，用于在生成分页链接时保存原有的GET参数
    private function getUrlParams()
    {
        //去掉page参数并重新生成GET参数字符串
        $params = $_GET;
        unset($params['page']);
        return http_build_query($params);
    }
    //获取分页链接
    public function showPage()
    {
        //如果少于1页则不显示分页导航
        if ($this->pagenum<=1) {
            return '';
        }
        //获取原来的GET参数
        $url = $this->getUrlParams();
        //拼接URL参数
        $url = $url ? "?$url&page=" : "?page=";
        //拼接“首页”
        $first = '<a href="'.$url.'1">[首页]</a>';
        //拼接“上一页”
        $prev = ($this->current == 1) ? '[上一页]' : '<a href="'.$url.($this->current-1).'">[上一页]</a>';
        //拼接“下一页”
        $next = ($this->current == $this->pagenum) ? '[下一页]' : '<a href="'.$url.($this->current+1).'">[下一页]</a>';
        //拼接“尾页”
        $last = '<a href="'.$url.$this->pagenum.'">[尾页]</a>';
        //组合最终样式
        return "当前为 {$this->current}/{$this->pagenum}　{$first}　{$prev}　{$next}　{$last}";
    }
}
