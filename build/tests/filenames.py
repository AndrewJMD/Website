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
common_extensions = ["sample","yml","html","php","json","css","py","js","otf","svg","woff","woff2","ttf","eot","less","scss","jpg","png","sh","md","gif","map","conf","sql","xml","lock"]
uppercase_exceptions = ["README.md","Vagrantfile","FontAwesome.otf"]

scandir = ""
try:
    scandir = sys.argv[1]
except IndexError:
    scandir = "."

ret = 0

for root, dirs, files in os.walk(scandir):
    if ".git" not in root and "/tests/" not in root and "/vendor/" not in root:
        for f in files:
            if f not in uppercase_exceptions and f[0].lower() != f[0]:
                print "Leading Uppercase Character:",os.path.join(root,f)
            for i in invalid_characters:
                if i in f:
                    # Sass uses underscores for partials
                    # Camelcase in shell is not standard practice
                    if not (i == "_" and f.split(".")[-1] in ["scss","sh"]):
                        print "Invalid Character ("+i+"):",os.path.join(root,f)
                        ret = 1
            for i in invalid_names:
                if len(f.replace(i,"")) < 6 and "." in f:
                    print "Undescriptive name:",os.path.join(root,f)
                    break
            if os.path.splitext(f)[1][1:] not in common_extensions and os.path.splitext(f)[1][1:] != "":
                print "Uncommon Extension ("+os.path.splitext(f)[1][1:]+")",os.path.join(root,f)

sys.exit(ret)
