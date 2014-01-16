---
layout: post
title: "测试代码高亮"
description: "测试"
category: "杂乱"
tags: [杂乱]
---
---
###例子

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
  private String Id;
  private ArrayList<Record> record = new ArrayList<Record>(); // 规定泛型类型

  public Book(String name, String head) throws ClassNotFoundException {// 只有名字的构造器
    this.bookName = name;
    this.sequence = new Sequence(head);
    this.Id = sequence.toString();
    this.bookRentLevel = 0;
  }

  public Book(String name, String head, int bookRentLevel) throws ClassNotFoundException, SQLException {// 带图书级别的构造器
    this.bookName = name;
    this.bookRentLevel = bookRentLevel;
    this.sequence = new Sequence(head);
    this.Id = sequence.toString();
    Class.forName("com.mysql.jdbc.Driver");
    java.sql.Connection connection =
        DriverManager.getConnection("jdbc:mysql://localhost/book_mgr?characterEncoding=utf8",
            "root", "121126");
//    System.out.println("连接成功！");
//    connection.setAutoCommit(false);
    Statement statement = connection.createStatement();
    statement.execute("insert book (bookid,name,status,booklevel,checkoutsum)value('" + Id + "','"
        + bookName + "', 0 ,'" + bookRentLevel + "','" + rentCounts + "')");
    connection.close();
//    System.out.println("连接关闭！");
    JOptionPane.showMessageDialog(null, "添加成功！", "提示", 1);
  }

  public int getStatus() {
    return status;
  }

  public void setStatus(int status) {
    this.status = status;
  }

  public int getRentCounts() {
    return rentCounts;
  }

  public void setRentCounts() {
    this.rentCounts++;
  }

  public int getBookLevel() {
    return bookRentLevel;
  }

  public void setBookLevel(int bookLevel) {
    this.bookRentLevel = bookLevel;
  }

  public String getId() {
    return Id;
  }

  public Record newRecord() {
    return new Book.Record();
  }


  public ArrayList<Record> getRecord() {
    return record;
  }

  public void setRecord(ArrayList<Record> record) {
    this.record = record;
  }


  /**
   * 记录卡类 包括借出日期，归还日期，图书名字,扩展到借阅者名字
   * */
  public class Record {
    private long checkOutTime;
    private long checkInTime = 0;
    private double totalPrice;
    private String username;
    private double totalfajin = 0;
    Date date = new Date();
    SimpleDateFormat timeformat = new SimpleDateFormat("yyyy-MM-dd");// 格式化时间输出
    
    public Record() {
      try {
        Connection connection =
            DriverManager.getConnection("jdbc:mysql://localhost/book_mgr?characterEncoding=utf8", "root", "121126");
//        System.out.println("连接成功！");
        Statement statement = connection.createStatement();
        statement.execute("insert record (booknumber,userid,checkout,checkin,plan,rent,fajin)value('"+Id+"','"+username+"','"+timeformat.format(checkOutTime)+"','"+timeformat.format(checkInTime)+"','"+timeformat.format(checkInTime+30*24*60*60*1000)+"','"+totalPrice+"','"+totalfajin+"')");      
        connection.close();
//        System.out.println("连接关闭！");
      } catch (SQLException e1) {
//        System.out.println("sql wrong!");
//        e1.printStackTrace();
      }
      this.checkOutTime = date.getTime();
      this.checkInTime = 0;
      this.totalPrice = 0;
      // this.username=username;
    }

    public String getUsername() {
      return username;
    }

    public void setCheckOutTime(long checkOutTime) {
      this.checkOutTime = checkOutTime;
    }

    public String getCheckOutTime() {
      return timeformat.format(checkOutTime);
    }

    // public long getCheckInTime() {
    // return checkInTime;
    // }
    public String getCheckInTime() {
      if (checkInTime == 0)
        return "该图书未归还";
      else
        return timeformat.format(checkInTime);
    }

    public String getTotalPrice() {
      return "" + totalPrice;
    }

    public void setCheckInTime(long checkInTime) {
      this.checkInTime = checkInTime;
    }


    @Override
    public String toString() {

      return "借出日期" + timeformat.format(checkOutTime) + " 归还日期：" + timeformat.format(checkInTime)
          + " 本次费用：" + totalPrice;
    }

    public double rentFee(long checkInTime, double rentPrice) {// 根据日期计算费用
      totalPrice = ((checkInTime - checkOutTime) / (24 * 60 * 60 * 1000) + 1) * rentPrice;// 測試方便
                                                                                          // 先加一
      // System.out.println("总共借阅天数： "+((checkInTime-checkOutTime)/(24*60*60*1000)+1));
      return totalPrice;
    }

    public double fajin(long checkInTime, double fajinfee) {
      
      if (((checkInTime - checkOutTime) / (24 * 60 * 60 * 1000)) > 30) {
        totalfajin = ((checkInTime - checkOutTime) / (24 * 60 * 60 * 1000) - 30) * 2;// 默认罚金为2元一天，后期可以设置
        return totalfajin;
      }
      return totalfajin;
    }
   
  }
}

{% endhighlight %}
