---
layout: post
title: "浅显的理解Async异步操作"
description: "android learning"
category: [杂乱]
tags: [android,学习,thinking]
---

###Learning of Async 
####异步操作
***
Android学习了一个多月,由于也有一定的java基础,java里面的好多方法基本都通用,也在于安卓   
整体入门不是太难,所以基本也掌握了基础的安卓功能的用法.    
由于移动设备的资源局限性,对于处理安卓和java还是有很多区别的.对于对象的new还有变量的作用域  
也格外需要处理.  
最近学习了多线程,有几种处理多线程的方法(主要是为了解决UI阻塞的问题)也看了,感觉也是似懂非懂的  
接受新鲜事务总是这样的,需要个时间.只要多用慢慢就理解其具体的用法和特征了.就像我们谁也没过多  
的学习汉语的语法不也是照样运用的很灵活么.都是一个道理.  
  
这个是个小小的异步操作的例子就是将耗时操作在另外开辟的线程中进行:
  {% highlight java %}

//传入三个Void对象,为空对象
public class FirstAsyncTask extends AsyncTask<Void, Void, Void> {
    @Override
    protected Void doInBackground(Void... params) {//该方法是在新线程里面做的事情,不会阻塞原来的线程里的事情
        NetOperator netOperator = new NetOperator();
        netOperator.operator();//耗时操作,这里进行耗时例如访问网络,加载图片,下载等
        return null;
    }
}  
{% endhighlight %}  
也就是在调用耗时操作是可以新开辟一个AsyncTask,在其中进行.  
对于Async对象有几个复写对象:分别为onPreExecute(),doInbackground(),onPostExecute(),这三个方法  
对应着一个异步操作的创建,运行和销毁.下面用我写的一个例子实际看一下:  
{% highlight java %}
   //进行异步操作之前的ui准备工作
    @Override
    protected void onPreExecute() {
        textView.setText("开始执行异步操作~");
    }
       
     //该方法不运行在ui线程中,该方法不能设置ui相关的东西,可以进行后台耗时操作等,不能和UI进行交互
    @Override
    protected String doInBackground(Integer... params) {
        NetOperator netOperator = new NetOperator();
    }
         //最后执行,是在ui中执行的
    @Override
    protected void onPostExecute(String s) {
        textView.setText("异步执行结束了,调用了onPostExecute方法" + s);

    }
{% endhighlight %}  
总结一下一个异步操作的运行过程:   

+   生成该类的对象,并调用execute方法
+   首先执行onPreExecute,处理后台任务启动前的UI工作 
+   其次执行doInBackgrount方法
+   最后执行 onPostExecute方法,和UI进行交互,返回UI结果  
***
***




