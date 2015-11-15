#! /usr/bin/env python
# -*- coding: utf-8 -*-
# vim:fenc=utf-8
#
# Copyright © 2015 raghuram <raghuram@raghuram-HP-Pavilion-g6-Notebook-PC>
#
# Distributed under terms of the MIT license.

"""

"""

from bs4 import BeautifulSoup

f=open('course.html','r')

parsed=BeautifulSoup(f);

linn=[]

for data in parsed.find_all('li',{'class':'post'}):
    for data2 in data.find_all('div',{'class':'head clearfix'}):
        for data3 in data2.find_all('div', {'class':'date'}):
            linn.append(data3.text.strip()+"\n")
        for data3 in data2.find_all('div', {'class':'name'}):
            linn.append(data3.text.strip()+"\n")
    for data3 in data.find_all('div',{'class':'info'}):
        linn.append(data3.text.strip()+"\n")

f2=open('posts.txt','w')
f2.writelines(linn)
f2.close()
f.close()
