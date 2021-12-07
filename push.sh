#!/bin/bash
# clear screen
clear
# get the release comment
commitMsg=$1
# check comment
if [[ ! -n $commitMsg ]]; then
	commitMsg=`date "+%Y${dateExp}%m${dateExp}%d${exp}%H${secExp}%M"`
fi
# commit the comment
git commit -m $commitMsg
# push
git push
# tip
if [[ $? -ne 0 ]]; then
	echo "push fail"
else
	echo "push success"
fi