copy(src, dst) {
    let stat = fs.stat;
    this.mkdirsSync(dst);
    // 读取目录中的所有文件/目录
    const that = this;
    fs.readdir(src, function (err, paths) {
      if (err) {
        throw err;
      }
      paths.forEach(function (path) {
        var _src = src + '/' + path,
          _dst = dst + '/' + path,
          readable, writable;

        stat(_src, function (err, st) {
          if (err) {
            throw err;
          }
          // 判断是否为文件
          if (st.isFile()) {
            // 创建读取流
            readable = fs.createReadStream(_src);
            // 创建写入流
            writable = fs.createWriteStream(_dst);
            // 通过管道来传输流
            readable.pipe(writable);
          }
          // 如果是目录则递归调用自身
          else if (st.isDirectory()) {
            that.exists(_src, _dst, that.copy);
          }
        });
      });
    });
  };

  exists(src, dst, callback) {
    fs.exists(dst, function (exists) {
      // 已存在
      if (exists) {
        callback(src, dst);
      }
      // 不存在
      else {
        fs.mkdir(dst, function () {
          callback(src, dst);
        });
      }
    });
  };



  mkdirsSync(dirname) {
    if (fs.existsSync(dirname)) {
      return true;
    }
    if (this.mkdirsSync(path.dirname(dirname))) {
      fs.mkdirSync(dirname);
      return true;
    }

  }
