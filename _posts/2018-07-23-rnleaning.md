---
#layout: post
#title: 'Hello Jekyll'
#date: 2017-04-18
#author: mtcle
#cover: 'http://on2171g4d.bkt.clouddn.com/jekyll-banner.png'
#tags: react-native
layout: post
title: 'react-native 填坑'
date: 2018-07-23
author: mtcle
cover: 'http://on2171g4d.bkt.clouddn.com/jekyll-banner.png'
tags: react-native
---

# 学习rn笔记
## 环境
> 最新版本0.56.0 有问题     
使用指定版本创建rn  
`react-native init MyApp --version 0.55.0`  
当有奇奇怪怪的问题无法解决的时候：试试`npm cache clean --force`    
配置webstom [自动提示rn](https://blog.csdn.net/teagreen_red/article/details/77074333)

### npm安装包方式
- `sudo npm install -global [package name]`
- `npm install git://github.com/package/path.git`
- `npm install git://github.com/package/path.git#0.1.0`
- `npm install package_name@version`
- `npm install path/to/somedir  //本地路径`     

### rn开发   
模拟器Ctrl+M 打开菜单   

## 界面开发
### flex布局 [详情](http://www.cnblogs.com/moyuling/p/562ec056372dd112ee96d3d24d410da8.html)
**root布局**

> display：flex   
{% highlight css %}flex-direction: column|（默认水平）row（垂直）      
justify-content：center（水平方向居中，垂直不居中）|flex-start || flex-end     
align-items：center（垂直方向居中，水平不居中）|flex-start || flex-end         
子布局中使用（margin：auto）也能居中，但是不是太可控      
不设置宽高的话就是子控件的最大值 

{% endhighlight %}	

**子布局内容布局**      
> text-align:center;可以实现文字的水平方向居中      
line-height：div高度；可实现文字的垂直方向居中        

## JavaScript语法
- 代码块中不要用var，var的作用域会超过代码块，例如for循环里面用var定义的变量，外面是可以引用的。let没有问题。
- `Object.assign`方法(浅拷贝)
第一个参数是目标对象，后面的参数都是源对象  
{% highlight javascript %}	
const target = { a: 1, b: 1 };
const source1 = { b: 2, c: 2 };
const source2 = { c: 3 };
Object.assign(target, source1, source2);
target // {a:1, b:2, c:3}
{% endhighlight %}   
`Object.assign`拷贝的属性是有限制的，只拷贝源对象的自身属性（不拷贝继承属性），也不拷贝不可枚举的属性（`enumerable: false`）
    
- Symbol() ES6引入得到一个唯一值    
   是第七种数据类型，前六种是：undefined、null、布尔值（Boolean）、字符串（String）、数值（Number）、对象（Object）  
   可以使用`const COLOR_RED= Symbol();`来定义一个常量，这个常量就是唯一值
- Set 和java的Set一样，都是不能有重复值    
>    
```
add(value)：添加某个值，返回 Set 结构本身。
delete(value)：删除某个值，返回一个布尔值，表示删除是否成功。
has(value)：返回一个布尔值，表示该值是否为Set的成员。
clear()：清除所有成员，没有返回值。
```
- Proxy 代理，有点类似拦截器    
- Promise 异步操作容器[引用](http://www.cnblogs.com/lvdabao/p/es6-promise-1.html)
        
{% highlight javascript%}   
const promise = new Promise((resolve, reject) => {
setTimeout(function () {
 console.log('耗时操作执行完成');
 resolve('随便什么数据');
}, 2000);

setTimeout(function () {
 console.log('耗时操作执行失败');
 reject('随便什么数据');
}, 3000);

}).then((value) => {
 console.log("resolve结果：" + value)
}, (reason, data) => {
 console.log("reject结果：" + reason);
});
{% endhighlight%}
- 类		
{% highlight javascript %}  
class Point {
 constructor() {
  // ...
 }

 toString() {
 // ...
 }

}
let b = new Point();
b.toString();
{% endhighlight %}

 类可继承和java很像，继承后如果需要重写构造函数的时候，必须要调用`super()`     
    
- Decorator     
- 模块（module）    

{% highlight javascript %}	
// CommonJS模块
let { stat, exists, readFile } = require('fs');

// 等同于
let _fs = require('fs');
let stat = _fs.stat;
let exists = _fs.exists;
let readfile = _fs.readfile;
// ES6模块
import { stat, exists, readFile } from 'fs';	
{% endhighlight %}  

ES6 的模块自动采用严格模式，不管你有没有在模块头部加上`use strict`;		
	
严格模式主要有以下限制:

- 变量必须声明后再使用
- 函数的参数不能有同名属性，否则报错
- 不能使用with语句
- 不能对只读属性赋值，否则报错
- 不能使用前缀 0 表示八进制数，否则报错
- 不能删除不可删除的属性，否则报错
- 不能删除变量delete     prop，会报错，只能删除属性delete     global[prop]
- eval不会在它的外层作用域引入变量
- eval和arguments不能被重新赋值
- arguments不会自动反映函数参数的变化
- 不能使用arguments.callee
- 不能使用arguments.caller
- 禁止this指向全局对象
- 不能使用fn.caller和fn.arguments获取函数    调用的堆栈
- 增加了保留字（比如protected、static和interface）		


**export** 	

 导出模块、方法、变量。不导出外面用不到  
   
{% highlight javascript %}

 // profile.js
 var firstName = 'Michael';
 var lastName = 'Jackson';
 var year = 1958;
 //导出变量
 export {firstName, lastName, year};
 
 //也能导出，引用的时候就是 f l y
 export{f as firstName,l as lastName,y as year}
   
   //导出方法
 export function f() {};
   
 function f() {}
 export {f};
   
   
 //导出模块
 。。。  
   
{% endhighlight %}  
 export default命令是不指定具体别名，导出变量、方法、类等。  
 import的时候就可以随意起名字import了 `import xxx form aaaModule`    **这时候不能用{}了**   
    
**import**   
引入模块,静态分析阶段执行的，不能有语法其他操作  

{% highlight javascript %}	

  //变量名必须和输出的名字一致，所以说很麻烦，有了export default。 
  import {firstName, lastName, year} from './profile.js';
  //重命名 
  import { lastName as l } from './profile.js';
  
  {% endhighlight %}

  import（）和import是不同的    
  
{% highlight javascript %}	

 //可以动态引用！
if (condition) {
 import('moduleA').then(...);
} else {
 import('moduleB').then(...);
}
//import()加载模块成功以后，这个模块会作为一个对象，当作then方法的参数。
//因此，可以使用对象解构赋值的语法，获取输出接口
import('./myModule.js')
.then(myModule => {
 console.log(myModule.default);
});	

{% endhighlight%}
**module的加载实现**
{% highlight html %}
 <!-- 1、传统做法-->
 <!-- 页面内嵌的脚本 -->
 <script type="application/javascript">

 </script>
 <!-- 外部脚本，通过defer或async属性 表示该module是同步加载还是异步加载-->
 <script type="application/javascript" src="path/to/myModule.js" defer|async></script>

 <!-- 2、es6做法-->
 <!-- es6模块全是异步加载，无法设置同步-->
 <script type="module" src="./foo.js"></script>

{% endhighlight%}

---