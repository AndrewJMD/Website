import os, sys

"""
Filename Consistency and SEO checks

Errors:
 - Invalid Characters
 - Uppercase Characters

Warnings:
 - Uncommon File Extensions
 - Undescriptive / Non-SEO

"""

invalid_names = ["image","picture","pic","img","file","page"]
invalid_characters = "()'\"!@#$%^&*_=+{}[]|\\/,?"
common_extensions = ["sample","yml","html","php","json","css","py","js","otf","svg","woff","woff2","ttf","eot","less","scss","jpg","png","sh","md","gif","map","conf"]

scandir = ""
try:
    scandir = sys.argv[1]
except:
    scandir = "."

ret = 0

for root, dirs, files in os.walk(scandir):
    if ".git" not in root and "/tests/" not in root:
        for file in files:
            if os.path.join(root,file)[0].lower() != os.path.join(root,file)[0]:
                print "Leading Uppercase Character:",os.path.join(root,file)
            for i in invalid_characters:
                if i in file:
                    # Sass uses underscores for partials
                    # Camelcase in shell is not standard practice
                    if not (i == "_" and file.split(".")[-1] not in ["scss","sh"])):
                        print "Invalid Character ("+i+"):",os.path.join(root,file)
                        ret = 1
            for i in invalid_names:
                if len(file.replace(i,"")) < 6 and "." in file:
                    print "Undescriptive name:",os.path.join(root,file)
                    break
            if os.path.splitext(file)[1][1:] not in common_extensions and os.path.splitext(file)[1][1:] != "":
                print "Uncommon Extension ("+os.path.splitext(file)[1][1:]+")",os.path.join(root,file)

sys.exit(ret)
