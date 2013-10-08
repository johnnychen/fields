字段管理系统
=============

目前主要处理字段校验相关的问题

安装
===============
本系统基于wordpress 的主题搭建，将theme/validator拖入到wordpress站点的/wp-content/themes目录中即可。

本主题依赖如下开源wordpress插件，请确保这些插件已经安装：

* [Posts 2 Posts](http://scribu.net/wordpress/posts-to-posts/)
* [Types](http://wordpress.org/plugins/types/)
	
	types功能很多，本系统只使用了其中的custom-fields功能，对不同文章类型添加了不同的自定义属性：
	
	* type=`i18n` 增加`en-us`,`cn-zh`,`cn-tw`
	* type=`rule` 增加`priority`