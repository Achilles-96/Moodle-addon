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

f=open('final.html','r')
parsed=BeautifulSoup(f);

var=0

for data in parsed.find_all('p'):
    if str(data.text.strip())!="":
        var+=1

f.close()

if(var==0):
    f3=open('failed_request.html','r')
    f2=open('final.html','w')
    for line in f3:
        f2.writelines(line)
    f3.close()
    f2.close()
