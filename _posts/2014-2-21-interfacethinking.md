---
layout: post
title: "thinking of interface"
description: "整理出来更好的帮助自己理解一下接口"
category: "笔记"
tags: [interface]
---  

出来混迟早是要还的  
java接口那部分一直是基础学习阶段掌握不牢固的部分，看看例子有点似懂非懂的，反正是自己还是不会用。  
今天就整理一下，帮助自己理解吧。   

--- 
接口嘛，例如主板上面提供各种各样的接口，方便后期计算机升级扩展。java嘛我想也是出于这种考虑  
毕竟是完全面向对象的，肯定扩展得灵活，依赖得最小化。所以就有了interface～  
接口的引入一般会增加代码量（眼前是），但非常有利于后期扩展。（还是例如主板上留的内存插槽，肯定造价比  
直接把内存条焊接在上面高～～）   
好了，废话一大堆了，开始举个小例子用一下这个interface   
我们来个劲爆的例子，杀人，而杀人又有千千万万个方法（变态吧～为了增加印象嘛），为了解决这个问题，提供  
一个杀人接口只说是杀人，怎么杀人留给实现者来给出具体的解决方法。 
  
kill person：   

{% highlight java%}   

public interface KillPerson {

  public void kill(Person p);

}  
{% endhighlight %}  

  
主流方法，枪杀：  
{% highlight java%}  
public class GunKill implements KillPerson{
  public void kill(Person p){
    System.out.println(p.getName()+"枪杀了！");
  }
}  
{% endhighlight %}  
  
变态方法，下毒：  
{% highlight java%}  
 
public class YaoKill implements KillPerson {
  public void kill(Person p) {
    System.out.println(p.getName() + "毒药药死了！");
  }
}
{% endhighlight %}   
 
等等，还有n多方法可以实现杀死人，法律禁止，这里就不敢再说了，怕查水表呃呃  
这些具体怎么来杀就是实现了接口中的杀人方法。  
其实这里还是可以和内存条，内存插槽打比喻的。内存就是储存临时数据，主板生产内存插槽时，不管将来  
这里插的哪种品牌哪种容量的内存条，其相同的功能就都是存储数据的。  
这里杀人方法就是不同的内存条，杀人吶就是对应着存储数据。 
 
---  

好了，interface我就理解到这，有好的见解欢迎留言～  

-------


