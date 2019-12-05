---
layout: post
title: 'android ndk详细配置'
date: 2019-12-05
author: mtcle
cover: '/source/pages/ndk.png'
tags: ndk
---

# Android NDK 详细配置
## 1、Android.mk文件配置详解
一个包含native代码的android项目，可以分为多个模块，每个模块使用对应的`android.mk`文件 	
    
以下是常用配置详解：
{% highlight bash %}

LOCAL_PATH := $(call my-dir) #指定当前文件路径

include $(CLEAR_VARS) # 变量初始化或取消定义与模块相关的变量

LOCAL_MODULE := modulea # 模块名字，编译出来的名字

LOCAL_MODULE_FILENAME :=newName  # 自定义名称

LOCAL_CPPFLAGS += -std=c++11 # 使用c++ 11特性

LOCAL_LDLIBS := -llog # 使用android系统自带的log库

LOCAL_C_INCLUDES := $(LOCAL_PATH)/include # 指定头文件路径

LOCAL_SRC_FILES += $(LOCAL_PATH)/3rd_party/platform/android/src/sqlite3.c # 指定c文件或者cpp文件路径

include $(BUILD_SHARED_LIBRARY) # 指定编译出来的库类型，编译出来动态库


include $(BUILD_STATIC_LIBRARY) # 指定编译出来静态库a

# 该模块使用预编译好的库libfoo，so或者是a
include $(CLEAR_VARS)
LOCAL_MODULE := foo-prebuilt
LOCAL_SRC_FILES := libfoo.so
include $(PREBUILT_SHARED_LIBRARY)

{% endhighlight %}	
	
## 其他一些不常用配置
### LOCAL_WHOLE_STATIC_LIBRARIES 
多个静态库之间存在循环依赖关系时，此变量很有用，使用此变量编译共享库时，它将强制编译系统将静态库中的所有对象文件添加到最终二进制文件。但是，生成可执行文件时不会发生这种情况。
### LOCAL_LDFLAGS
列出了编译系统在编译共享库或可执行文件时使用的其他链接器标记。例如，要在 ARM/X86 上使用 ld.bfd 链接器`LOCAL_LDFLAGS += -fuse-ld=bfd`
### LOCAL_ALLOW_UNDEFINED_SYMBOLS
默认情况下，如果编译系统在尝试编译共享库时遇到未定义的引用，将会抛出“未定义的符号”错误。此错误可帮助您捕获源代码中的错误。
要停用此检查，请将此变量设置为 true

## 系统自带的宏定义
### my-dir
这个宏返回最后包含的 makefile 的路径，通常是当前 Android.mk 的目录
### all-subdir-makefiles
返回位于当前 my-dir 路径所有子目录中的 Android.mk 文件列表，默认情况下，NDK 只在 Android.mk 文件所在的目录中查找文件
### this-makefile
返回当前 makefile（编译系统从中调用函数）的路径。
### parent-makefile
返回包含树中父 makefile 的路径（包含当前 makefile 的 makefile 的路径）。

### grand-parent-makefile
返回包含树中祖父 makefile 的路径（包含当前父 makefile 的 makefile 的路径）。
### import-module
此函数用于按模块名称查找和包含模块的 Android.mk 文件


## 2、Application.mk
一个native项目只能有一个`Application.mk`
可以通过配置指定编译cpu架构，每一个架构解析一遍`Android.mk`，可以通过配置不同架构差异化

{% highlight bash %}
ifeq ($(TARGET_ARCH_ABI),arm64-v8a)
# ... do something ...
endif
{% endhighlight %}	

不同 CPU 和架构的 ABI 设置：		

|cpu和架构|变量|
|ARMv7|armeabi-v7a|
|ARMv8 AArch64|	arm64-v8a|
|x86|x86|
|x86-64|x86_64|
|所有支持的 ABI（默认）|all|

{% highlight bash %}

APP_ABI := x86 armeabi-v7a # 指定编译出来的so架构类型	
APP_STL := gnustl_static #GNU STL
APP_CPPFLAGS +=-std=c++11 #允许使用c++11的函数等功能
LOCAL_MULTILIB := 32
APP_PLATFORM=android-11

{% endhighlight %}

### APP_CFLAGS
要为项目中的所有 C/C++ 编译传递的标记
### APP_CONLYFLAGS
只会给c传递，不会给c++传递
### APP_CPPFLAGS
要为项目中的所有 C++ 编译传递的标记。这些标记不会用于 C 代码
### APP_DEBUG
设置是否可以调试
### APP_PLATFORM 
这个sdk版本指的用的ndk里面的特性，每个版本android暴露给ndk的方法有差异，所以这个版本要尽可能低，要低于上层设置的minSdkVersion
