import re, os, sys

rIMG    = r"<img(?:.+?)src=\"(.+?)\"(?:.+?)>"
rLINK   = r"<link(?:.+?)href=\"(.+?)\"(?:.+?)>"
rSCRIPT = r"<script(?:.+?)src=\"(.+?)\"(?:.+?)>"

scandir = ""
try:
    scandir = sys.argv[1]
except:
    scandir = "."

ret = 0

def check(text, regex):
    matches = re.finditer(regex, text)
    for matchNum, match in enumerate(matches):
        matchNum = matchNum + 1
        if len(match.groups()) != 0:
            src = match.group(1)
            if "http" not in src:
                if not os.path.isfile(src):
                    ret = 1
                    print "File not found:",os.path.join(root,file),src

for root, dirs, files in os.walk(scandir):
    for file in files:
        with open(os.path.join(root,file)) as f:
            check(f.read(), rIMG)
            check(f.read(), rLINK)
            check(f.read(), rSCRIPT)
