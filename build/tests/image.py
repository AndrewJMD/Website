from PIL import Image
import sys, os

"""

Image Validity Check

Errors:
 - File Corrupt / Invalid

"""

ret = 0

for root, dirs, files in os.walk(scandir):
    for file in files:
        i = None
        try:
            i = Image.open(os.path.join(root,file))
            i.verify()
        except:
            ret = 1
            
sys.exit(ret)
