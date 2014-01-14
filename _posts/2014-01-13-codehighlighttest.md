---
layout: post
title: "测试代码高亮"
description: "测试"
category: [杂乱]
tags: [杂乱]
---
---
{% highlight java %}

package model;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

import javax.swing.JOptionPane;

/**
 * 图书类 包括名字，状态，借出次数 属性 包括记录卡 租金类别
 * */
public class Book {
  public String bookName;// 名字
  private int status = 0;// 图书当前状态，默认为0在馆可借，借出为1
  private int rentCounts = 0;// 图书借阅次数
 		 private int bookRentLevel = 0;// 图书租金级别,默认为0,高级为1
  private Sequence sequence;// 定义一个图书序列号
{% endhighlight %}
