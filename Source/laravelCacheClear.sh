#! /bin/sh
# ********************************************************************************
# * @Author      : B.Koizumi
# * @Create Date : 2017/05/12
# * @Description : Laravel setup
# ********************************************************************************


# Laravelのrootディレクトリの指定
# echo "The last slash is unnecessary."
# echo -n "laravelRootDir [/path/to/hoge] >"
# read laravelRootDir

# echo "Change laravel root directory." ${laravelRootDir}
# cd ${laravelRootDir}

laravelRootDir=$(cd $(dirname $0); pwd)

echo ${laravelRootDir} " に入りました."

cd ${laravelRootDir}


php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
php artisan clear-compiled
#php artisan config:cache


