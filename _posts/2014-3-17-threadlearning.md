---
layout: post
title: "Thread&Handler"
description: "运用Handler和Thread来实现多线程异步加载"
category: "学习笔记"
tags: [android,learning]
---
## 异步加载,多线程
> 因为手机的性能和网络资源的特征,多线程和异步加载在android开发中相当重要,运用无处不在.  

### 这里就稍微总结一下自己运用Thread开辟新线程的例子.为自己mark~

### 先把代码贴上来
{% highlight java%}    
 
 
            //这个代码的实现目的是可以加载本地缓存里面的图片以减少流量和加载时间:
            //增加一个新个handler
          final Handler handler = new Handler() {
            @Override
            public void handleMessage(Message msg) {
                Drawable drawable = (Drawable) msg.obj;//获取handler发送的信息里面含有的对象obj,
                callBack.imageLoaded(drawable); // 转换成Drawable对象,将该值传递给接口中的待实现的方法
            }
        };

        //新开辟一个线程,在新线程里面处理下载图片的工作
        new Thread() {
            public void run() {
                Drawable drawable = LoadImageFromUrl(imageUri);
                imageCache.put(imageUri, new SoftReference<Drawable>(drawable));//将新的图片的信息加载到缓存中
                Message message = handler.obtainMessage(0, drawable);//得到一个消息
                handler.sendMessage(message);//发送该信息
            }

            ;
        }.start();
        return null;
    }


    //该方法用于根据url获取图片
    protected Drawable LoadImageFromUrl(String imageUrl) {
        try {
            //根据图片url下载图片,生成Drawable对象
            return Drawable.createFromStream(new URL(imageUrl).openStream(), "src");
        } catch (IOException e) {
            Log.d("异常", "图片url错误!");
            throw new RuntimeException(e);
        }
    }


    //这里是回调接口
    public interface ImageCallback {
        public void imageLoaded(Drawable imageDrawable);//待实现的方法,在CallbackImpl中实现了该方法
    }
}    

  
  {% endhighlight %}  
这个代码里面注意的:   
 
新的线程里面的操作要在`run()`方法里面写. 
 
***
#asynctask#
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
对于Async对象有几个复写对象:分别为`onPreExecute()`,`doInbackground()`,`onPostExecute()`,这三个方法  
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

### 总结一下一个异步操作的运行过程:   

+   生成该类的对象,并调用`execute`方法
+   首先执行`onPreExecute`,处理后台任务启动前的UI工作 
+   其次执行`doInBackgrount`方法
+   最后执行 `onPostExecute`方法,和UI进行交互,返回UI结果  
+   每次使用对象的时候必须`new`，不能直接引用对象调用它的`execute`方法 


