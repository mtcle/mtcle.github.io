---
layout: post
title: 'android 源码编译'
date: 2018-10-23
author: mtcle
cover: '/source/pages/open-to-the-future.jpg'
tags: source build
---

# Android源码编译
## 环境准备
Ubuntu 14.04  open-jdk8 	
    
添加openjdk8的第三方源	
1. sudo add-apt-repository ppa:openjdk-r/ppa		
2. sudo apt-get update		
3. sudo apt-get install openjdk-8-jdk	
	
### 安装编译需要的lib
{%highlight bash%}
sudo apt-get install libx11-dev:i386 libreadline6-dev:i386 libgl1-mesa-dev g++-multilib 
sudo apt-get install -y git flex bison gperf build-essential libncurses5-dev:i386 
sudo apt-get install tofrodos python-markdown libxml2-utils xsltproc zlib1g-dev:i386 
sudo apt-get install dpkg-dev libsdl1.2-dev libesd0-dev
sudo apt-get install git-core gnupg flex bison gperf build-essential  
sudo apt-get install zip curl zlib1g-dev gcc-multilib g++-multilib 
sudo apt-get install libc6-dev-i386 
sudo apt-get install lib32ncurses5-dev x11proto-core-dev libx11-dev 
sudo apt-get install libgl1-mesa-dev libxml2-utils xsltproc unzip m4
sudo apt-get install lib32z-dev ccache

{%endhighlight%}	
### 安装curl、git

* sudo apt-get install curl
* sudo apt-get install git
* git config --global user.email "xxx@yyy.com
* git config --global user.name "xxx"
	
## 初始化源码文件
###	1、下载安装repo
{%highlight bash%}
mkdir ~/bin
PATH=~/bin:$PATH
curl https://storage.googleapis.com/git-repo-downloads/repo > ~/bin/repo
chmod a+x ~/bin/repo
或者用清华的镜像	
curl https://mirrors.tuna.tsinghua.edu.cn/git/git-repo -o repo
chmod +x repo
{%endhighlight%}
###	2、创建源码文件夹		
* mkdir source
* cd source	

###	3、初始化代码库
`repo init -u https://aosp.tuna.tsinghua.edu.cn/platform/manifest -b android-7.1.1_r22`		
后面的版本号可以参考[版本](/source/source_version.html)	
如果有访问google被墙的话，将repo里面google的地址替换为https://aosp.tuna.tsinghua.edu.cn
###	4、同步代码库
repo sync  漫长的等待		

## 全量编译
1. 初始化编译环境		
	 source build/envsetup.sh
2. 选择编译目标
	lunch aosp_arm64-eng 也可以选择其他目标，不跟参数，直接lunch即可
3. 开始编译
	make -j4 后面的4是cpu内核二倍即可
4. 漫长编译完成后，执行emulator 即可运行	

## 模块编译
1. `./build/envsetup.sh` 执行后可以获得对应指令
2. 每个目录只包含一个模块.比如这里我们要编译Launcher2模块,执行指令:`mmm packages/apps/Launcher2/`		
3. 编译成功后`out/target/product/gereric/system/app`目录下即可看到对应的Launcher2.apk文件
4. 将新的apk打包进入system.img里面:make snod
5. 不打包直接安装也可以：adb install Launcher2.apk

## tip	
Android 自带的emulator 有时会有没有模拟键，adb连接不上等问题，建议大家可以使用Android Studio的模拟器，有几个注意点： 
1. 我们编译的是aosp_arm64-eng ，所以Android Studio 创建AVD时要选择arm的，不要选x86. 
2. 把自己编译好的（路径在out/target/product/generic/下）system.img， 
userdate.img ，ramdisk.img拷贝到 Android Studio SDK所在目录下的system-images/android-25/google_apis/arm64-v84/下，替换掉原有的文件，运行之前创建的AVD即可，等几分钟就可以看到自己百编译的系统了		

---