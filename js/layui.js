/*!

 @Title: Layui
 @Description锛氱粡鍏告ā鍧楀寲鍓嶇妗嗘灦
 @Site: www.layui.com
 @Author: 璐ゅ績
 @License锛歁IT

 */
 
;!function(win){
  
"use strict";

var Lay = function(){
  this.v = '1.0.9_rls'; //鐗堟湰鍙�
};

Lay.fn = Lay.prototype;

var doc = document, config = Lay.fn.cache = {},

//鑾峰彇layui鎵€鍦ㄧ洰褰�
getPath = function(){
  var js = doc.scripts, jsPath = js[js.length - 1].src;
  return jsPath.substring(0, jsPath.lastIndexOf('/') + 1);
}(),

//寮傚父鎻愮ず
error = function(msg){
  win.console && console.error && console.error('Layui hint: ' + msg);
},

isOpera = typeof opera !== 'undefined' && opera.toString() === '[object Opera]',

//鍐呯疆妯″潡
modules = {
  layer: 'modules/layer' //寮瑰眰
  ,laydate: 'modules/laydate' //鏃ユ湡
  ,laypage: 'modules/laypage' //鍒嗛〉
  ,laytpl: 'modules/laytpl' //妯℃澘寮曟搸
  ,layim: 'modules/layim' //web閫氳
  ,layedit: 'modules/layedit' //瀵屾枃鏈紪杈戝櫒
  ,form: 'modules/form' //琛ㄥ崟闆�
  ,upload: 'modules/upload' //涓婁紶
  ,tree: 'modules/tree' //鏍戠粨鏋�
  ,table: 'modules/table' //瀵岃〃鏍�
  ,element: 'modules/element' //甯哥敤鍏冪礌鎿嶄綔
  ,util: 'modules/util' //宸ュ叿鍧�
  ,flow: 'modules/flow' //娴佸姞杞�
  ,carousel: 'modules/carousel' //杞挱
  ,code: 'modules/code' //浠ｇ爜淇グ鍣�
  ,jquery: 'modules/jquery' //DOM搴擄紙绗笁鏂癸級
  
  ,mobile: 'modules/mobile' //绉诲姩澶фā鍧� | 鑻ュ綋鍓嶄负寮€鍙戠洰褰曪紝鍒欎负绉诲姩妯″潡鍏ュ彛锛屽惁鍒欎负绉诲姩妯″潡闆嗗悎
  ,'layui.all': 'dest/layui.all' //PC妯″潡鍚堝苟鐗�
};

config.modules = {}; //璁板綍妯″潡鐗╃悊璺緞
config.status = {}; //璁板綍妯″潡鍔犺浇鐘舵€�
config.timeout = 10; //绗﹀悎瑙勮寖鐨勬ā鍧楄姹傛渶闀跨瓑寰呯鏁�
config.event = {}; //璁板綍妯″潡鑷畾涔変簨浠�

//瀹氫箟妯″潡
Lay.fn.define = function(deps, callback){
  var that = this
  ,type = typeof deps === 'function'
  ,mods = function(){
    typeof callback === 'function' && callback(function(app, exports){
      layui[app] = exports;
      config.status[app] = true;
    });
    return this;
  };
  
  type && (
    callback = deps,
    deps = []
  );
  
  if(layui['layui.all'] || (!layui['layui.all'] && layui['layui.mobile'])){
    return mods.call(that);
  }
  
  that.use(deps, mods);
  return that;
};

//浣跨敤鐗瑰畾妯″潡
Lay.fn.use = function(apps, callback, exports){
  var that = this, dir = config.dir = config.dir ? config.dir : getPath;
  var head = doc.getElementsByTagName('head')[0];

  apps = typeof apps === 'string' ? [apps] : apps;
  
  //濡傛灉椤甸潰宸茬粡瀛樺湪jQuery1.7+搴撲笖鎵€瀹氫箟鐨勬ā鍧椾緷璧杍Query锛屽垯涓嶅姞杞藉唴閮╦query妯″潡
  if(window.jQuery && jQuery.fn.on){
    that.each(apps, function(index, item){
      if(item === 'jquery'){
        apps.splice(index, 1);
      }
    });
    layui.jquery = jQuery;
  }
  
  var item = apps[0], timeout = 0;
  exports = exports || [];

  //闈欐€佽祫婧恏ost
  config.host = config.host || (dir.match(/\/\/([\s\S]+?)\//)||['//'+ location.host +'/'])[0];
  
  if(apps.length === 0 
  || (layui['layui.all'] && modules[item]) 
  || (!layui['layui.all'] && layui['layui.mobile'] && modules[item])
  ){
    return onCallback(), that;
  }

  //鍔犺浇瀹屾瘯
  function onScriptLoad(e, url){
    var readyRegExp = navigator.platform === 'PLaySTATION 3' ? /^complete$/ : /^(complete|loaded)$/
    if (e.type === 'load' || (readyRegExp.test((e.currentTarget || e.srcElement).readyState))) {
      config.modules[item] = url;
      head.removeChild(node);
      (function poll() {
        if(++timeout > config.timeout * 1000 / 4){
          return error(item + ' is not a valid module');
        };
        config.status[item] ? onCallback() : setTimeout(poll, 4);
      }());
    }
  }

  //鍔犺浇妯″潡
  var node = doc.createElement('script'), url =  (
    modules[item] ? (dir + 'lay/') : (config.base || '')
  ) + (that.modules[item] || item) + '.js';
  node.async = true;
  node.charset = 'utf-8';
  node.src = url + function(){
    var version = config.version === true 
    ? (config.v || (new Date()).getTime())
    : (config.version||'');
    return version ? ('?v=' + version) : '';
  }();
  
  //棣栨鍔犺浇
  if(!config.modules[item]){
    head.appendChild(node);
    if(node.attachEvent && !(node.attachEvent.toString && node.attachEvent.toString().indexOf('[native code') < 0) && !isOpera){
      node.attachEvent('onreadystatechange', function(e){
        onScriptLoad(e, url);
      });
    } else {
      node.addEventListener('load', function(e){
        onScriptLoad(e, url);
      }, false);
    }
  } else {
    (function poll() {
      if(++timeout > config.timeout * 1000 / 4){
        return error(item + ' is not a valid module');
      };
      (typeof config.modules[item] === 'string' && config.status[item]) 
      ? onCallback() 
      : setTimeout(poll, 4);
    }());
  }
  
  config.modules[item] = url;
  
  //鍥炶皟
  function onCallback(){
    exports.push(layui[item]);
    apps.length > 1 ?
      that.use(apps.slice(1), callback, exports)
    : ( typeof callback === 'function' && callback.apply(layui, exports) );
  }

  return that;

};

//鑾峰彇鑺傜偣鐨剆tyle灞炴€у€�
Lay.fn.getStyle = function(node, name){
  var style = node.currentStyle ? node.currentStyle : win.getComputedStyle(node, null);
  return style[style.getPropertyValue ? 'getPropertyValue' : 'getAttribute'](name);
};

//css澶栭儴鍔犺浇鍣�
Lay.fn.link = function(href, fn, cssname){
  var that = this, link = doc.createElement('link');
  var head = doc.getElementsByTagName('head')[0];
  if(typeof fn === 'string') cssname = fn;
  var app = (cssname || href).replace(/\.|\//g, '');
  var id = link.id = 'layuicss-'+app, timeout = 0;
  
  link.rel = 'stylesheet';
  link.href = href + (config.debug ? '?v='+new Date().getTime() : '');
  link.media = 'all';
  
  if(!doc.getElementById(id)){
    head.appendChild(link);
  }

  if(typeof fn !== 'function') return ;
  
  //杞css鏄惁鍔犺浇瀹屾瘯
  (function poll() {
    if(++timeout > config.timeout * 1000 / 100){
      return error(href + ' timeout');
    };
    parseInt(that.getStyle(doc.getElementById(id), 'width')) === 1989 ? function(){
      fn();
    }() : setTimeout(poll, 100);
  }());
};

//css鍐呴儴鍔犺浇鍣�
Lay.fn.addcss = function(firename, fn, cssname){
  layui.link(config.dir + 'css/' + firename, fn, cssname);
};

//鍥剧墖棰勫姞杞�
Lay.fn.img = function(url, callback, error) {   
  var img = new Image();
  img.src = url; 
  if(img.complete){
    return callback(img);
  }
  img.onload = function(){
    img.onload = null;
    callback(img);
  };
  img.onerror = function(e){
    img.onerror = null;
    error(e);
  };  
};

//鍏ㄥ眬閰嶇疆
Lay.fn.config = function(options){
  options = options || {};
  for(var key in options){
    config[key] = options[key];
  }
  return this;
};

//璁板綍鍏ㄩ儴妯″潡
Lay.fn.modules = function(){
  var clone = {};
  for(var o in modules){
    clone[o] = modules[o];
  }
  return clone;
}();

//鎷撳睍妯″潡
Lay.fn.extend = function(options){
  var that = this;

  //楠岃瘉妯″潡鏄惁琚崰鐢�
  options = options || {};
  for(var o in options){
    if(that[o] || that.modules[o]){
      error('\u6A21\u5757\u540D '+ o +' \u5DF2\u88AB\u5360\u7528');
    } else {
      that.modules[o] = options[o];
    }
  }
  
  return that;
};

//璺敱
Lay.fn.router = function(hash){
  var hashs = (hash || location.hash).replace(/^#/, '').split('/') || [];
  var item, param = {
    dir: []
  };
  for(var i = 0; i < hashs.length; i++){
    item = hashs[i].split('=');
    /^\w+=/.test(hashs[i]) ? function(){
      if(item[0] !== 'dir'){
        param[item[0]] = item[1];
      }
    }() : param.dir.push(hashs[i]);
    item = null;
  }
  return param;
};

//鏈湴瀛樺偍
Lay.fn.data = function(table, settings){
  table = table || 'layui';
  
  if(!win.JSON || !win.JSON.parse) return;
  
  //濡傛灉settings涓簄ull锛屽垯鍒犻櫎琛�
  if(settings === null){
    return delete localStorage[table];
  }
  
  settings = typeof settings === 'object' 
    ? settings 
  : {key: settings};
  
  try{
    var data = JSON.parse(localStorage[table]);
  } catch(e){
    var data = {};
  }
  
  if(settings.value) data[settings.key] = settings.value;
  if(settings.remove) delete data[settings.key];
  localStorage[table] = JSON.stringify(data);
  
  return settings.key ? data[settings.key] : data;
};

//璁惧淇℃伅
Lay.fn.device = function(key){
  var agent = navigator.userAgent.toLowerCase();

  //鑾峰彇鐗堟湰鍙�
  var getVersion = function(label){
    var exp = new RegExp(label + '/([^\\s\\_\\-]+)');
    label = (agent.match(exp)||[])[1];
    return label || false;
  };

  var result = {
    os: function(){ //搴曞眰鎿嶄綔绯荤粺
      if(/windows/.test(agent)){
        return 'windows';
      } else if(/linux/.test(agent)){
        return 'linux';
      } else if(/iphone|ipod|ipad|ios/.test(agent)){
        return 'ios';
      }
    }()
    ,ie: function(){ //ie鐗堟湰
      return (!!win.ActiveXObject || "ActiveXObject" in win) ? (
        (agent.match(/msie\s(\d+)/) || [])[1] || '11' //鐢变簬ie11骞舵病鏈塵sie鐨勬爣璇�
      ) : false;
    }()
    ,weixin: getVersion('micromessenger')  //鏄惁寰俊
  };
  
  //浠绘剰鐨刱ey
  if(key && !result[key]){
    result[key] = getVersion(key);
  }
  
  //绉诲姩璁惧
  result.android = /android/.test(agent);
  result.ios = result.os === 'ios';
  
  return result;
};

//鎻愮ず
Lay.fn.hint = function(){
  return {
    error: error
  }
};

//閬嶅巻
Lay.fn.each = function(obj, fn){
  var that = this, key;
  if(typeof fn !== 'function') return that;
  obj = obj || [];
  if(obj.constructor === Object){
    for(key in obj){
      if(fn.call(obj[key], key, obj[key])) break;
    }
  } else {
    for(key = 0; key < obj.length; key++){
      if(fn.call(obj[key], key, obj[key])) break;
    }
  }
  return that;
};

//闃绘浜嬩欢鍐掓场
Lay.fn.stope = function(e){
  e = e || win.event;
  e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
};

//鑷畾涔夋ā鍧椾簨浠�
Lay.fn.onevent = function(modName, events, callback){
  if(typeof modName !== 'string' 
  || typeof callback !== 'function') return this;
  config.event[modName + '.' + events] = [callback];
  
  //涓嶅啀瀵瑰娆′簨浠剁洃鍚仛鏀寔
  /*
  config.event[modName + '.' + events] 
    ? config.event[modName + '.' + events].push(callback) 
  : config.event[modName + '.' + events] = [callback];
  */
  
  return this;
};

//鎵ц鑷畾涔夋ā鍧椾簨浠�
Lay.fn.event = function(modName, events, params){
  var that = this, result = null, filter = events.match(/\(.*\)$/)||[]; //鎻愬彇浜嬩欢杩囨护鍣�
  var set = (events = modName + '.'+ events).replace(filter, ''); //鑾峰彇浜嬩欢鏈綋鍚�
  var callback = function(_, item){
    var res = item && item.call(that, params);
    res === false && result === null && (result = false);
  };
  layui.each(config.event[set], callback);
  filter[0] && layui.each(config.event[events], callback); //鎵ц杩囨护鍣ㄤ腑鐨勪簨浠�
  return result;
};

win.layui = new Lay();

}(window);
