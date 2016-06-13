---
layout: post
title: "continuous refactoring"
description: "refactoring of code"
category: "thinking java"
tags: [java,refactor]
---  

##  代码的持续重构
  

---  

代码之美在于不停的重构，不能满足于代码的现状，不能为了实现某个功能而编码，更好的是不停的追逐代码之最。   

--- 

最近呢，图书管理系统也算是完成了，怎么说是算完成呢？因为也就是把基本的业务逻辑完成了，符合了用  
户需求，但是这远远还不算完成。毕竟还有好多业务的实现分离以及更加有利于扩展的代码抽象等等的都还  
错的远呢。还有好多具体的小细节还没有实现。缺乏用户友好性，今天呢为系统添加了代码的国际化，以及  
记录用户数据信息等功能。这些是代码的功能的完善和用户友好度的增加。  
同时呢，也为了代码的后期扩展增加了可行性。派生出了一个baseJframe抽象类，该类继承了JFrame，其含有  
的方法有一个记忆用户图形界面操作后的数据，同时还含有一个国际化的获得菜单String的方法。供其他类继承  
使用。感觉挺好用的。 代码如下：  

{% highlight java%}
package base;


import java.awt.event.WindowEvent;
import java.awt.event.WindowListener;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.URL;
import java.util.Locale;
import java.util.Properties;
import java.util.ResourceBundle;

import javax.swing.JFrame;

public abstract class BaseJFrame extends JFrame implements WindowListener {
  /**
   * BaseJFrame是由JFrame派生出来的类，实现了windowsListener接口 是个抽象类，主要提供记忆frame用户拖动位置
   * 添加了国际化的方法，只要继承basejframe都可以使用
   */
  private static final long serialVersionUID = 4672571102889540948L;
  private File propertiesFile;
  private Properties settings;

  private static final int DEFAULT_WIDTH = 300;
  private static final int DEFAULT_HEIGHT = 200;

  public BaseJFrame() {
    String userDir = System.getProperty("user.home");
    File propertiesDir = new File(userDir, ".corejava");
    if (!propertiesDir.exists()) propertiesDir.mkdir();
    propertiesFile = new File(propertiesDir, this.getClass().getCanonicalName() + ".properties");
    settings = new Properties();
    settings.put("left", "0");
    settings.put("top", "0");
    settings.put("width", "" + DEFAULT_WIDTH);
    settings.put("height", "" + DEFAULT_HEIGHT);
    settings.put("title", "");
    loadProperties();
  }

  public URL getImageURL(String fileName) {
    return BaseJFrame.class.getResource(fileName);
  }

  public int getIntPrefs(String key) {
    return Integer.parseInt(getPrefs(key));
  }

  public String getPrefs(String key) {
    return settings.getProperty(key);
  }

  public void putPrefs(String key, String value) {
    settings.put(key, value);
  }

  @Override
  public void windowClosing(WindowEvent e) {
    putPrefs("left", "" + getX());
    putPrefs("top", "" + getY());
    putPrefs("width", "" + getWidth());
    putPrefs("height", "" + getHeight());
    putPrefs("title", getTitle());

    restoreProperties();
    System.exit(0);
  }

  public void restoreProperties() {
    try {
      FileOutputStream out = new FileOutputStream(propertiesFile);
      settings.store(out, "Program Properties");
    } catch (IOException ex) {
      // ignore
    }
  }

  public void loadProperties() {
    try {
      FileInputStream in = new FileInputStream(propertiesFile);
      settings.load(in);
    } catch (IOException ex) {
      // ignore
    }
  }

  public String getObj(String name) {// 传入某个值根据国家选择相应的语言返回出去
  // Locale locale = Locale.getDefault();
    Locale locale = new Locale("zh", "CN");
    // System.out.println(locale.getDisplayCountry());
    ResourceBundle bundle = ResourceBundle.getBundle("BookMgr", locale);
    name = bundle.getString(name);
    // System.out.println(bundle.getString(name));
    return name;
  }

  @Override
  public void windowOpened(WindowEvent e) {}

  @Override
  public void windowClosed(WindowEvent e) {}

  @Override
  public void windowIconified(WindowEvent e) {}

  @Override
  public void windowDeiconified(WindowEvent e) {}

  @Override
  public void windowActivated(WindowEvent e) {}

  @Override
  public void windowDeactivated(WindowEvent e) {}
}
  
{%endhighlight%}
  
---  
  
同时要在ssr下面建立国际化语言文件。例如：  
`BookMgr_en.properties`英文文件  
`BookMgr_zh_CN.properties`简体中文  
这些名字不是随意起的，`_`前面的是程序名字，后面的是固定的
