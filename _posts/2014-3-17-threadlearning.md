---
layout: post
title: "Thread&Handler"
description: "运用Handler和Thread来实现多线程异步加载"
category: "学习笔记"
tags: [android,learning]
---
####异步加载,多线程  
---  
因为手机的性能和网络资源的特征,多线程和异步加载在android开发中相当重要,运用无处不在.  
这里就稍微总结一下自己运用Thread开辟新线程的例子.为自己标记~  
***  

先把代码贴上来:
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
 
新的线程里面的操作要在run()方法里面写.  
***

