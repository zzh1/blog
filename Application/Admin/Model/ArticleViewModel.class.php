<?php
namespace Admin\Model;

use Think\Model\ViewModel;

class ArticleViewModel extends ViewModel
{
    public $viewFields = array(
        'Article'=>array('id','title','`desc`','pic','_type'=>'LEFT'),  //注意保留字符
        'Cate'=>array('catename', '_on'=>'Article.cateid=Cate.id'),
    );
}