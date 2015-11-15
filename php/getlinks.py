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

f=open('extract.html','r')

parsed=BeautifulSoup(f);

linn=[]
linn2=[]

for data in parsed.find_all('div',{'class':'info'}):
    linn2.append(data.text.strip()+"\n")
    for val in data('a'):
        linn.append(val['href']+"\n")


f2=open('links.txt','w')
f3=open('coursenames.txt','w')

f2.writelines(linn)
f3.writelines(linn2)

f2.close()
f3.close()
f.close()
