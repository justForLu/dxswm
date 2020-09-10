function ajaxSubmitForm(btn) {
  var btnText = btn.text(),
    form = btn.parents('form.J_ajaxForm');

  form.Validform({
    ajaxPost: true,
    tiptype: function (msg, o, cssctl) {
      if (!o.obj.is("form")) {
        var msgTip = o.obj.siblings(".msgTip");
        if (o.type != 2) {    // 排除成功提示信息
          cssctl(msgTip, o.type);
          layer.msg(msg);
        } else {
          cssctl(msgTip, 2);
          msgTip.text('');
        }
      }
    },
    datatype: {
      'max': function (gets, obj, curform, regxp) {//验证不能超过的最大值，不小于0，不能为空
        gets = parseFloat(gets);
        var max = parseFloat(obj.data('max'));
        if (gets > max || gets < 0 || gets == '') {
          return false;
        }
      }
    },
    beforeSubmit: function (form) {
      btn.attr('disabled', 'disabled');
      btn.text(btnText + '中..');
    },
    callback: function (data) {
      console.log(data);
      if (data.status == 'success') {
        layer.msg(data.msg, function () {
          console.log(data.referrer);
          if (data.referrer) {
            window.location.href = data.referrer;
          } else {
            window.location.reload();
          }
        })
      } else {
        btn.removeAttr('disabled');
        btn.text(btnText);
        layer.msg(data.msg);
      }
    }
  }).submitForm();
}

/**
 * 表单提交
 */
$('button.J_ajax_submit_btn').on('click', function () {
  ajaxSubmitForm($(this));
});

/**
 * 对话框弹出层
 */
if ($('a.J_layer_dialog').length) {
  var flag_dialog = true;    // 阻止多次点击触发事件
  $('a.J_layer_dialog').on('click', function (e) {
    e.preventDefault();
    var _this = $(this);
    var width = _this.data('w') ? _this.data('w') : '400px';
    var height = _this.data('h') ? _this.data('h') : 'auto';
    var title = _this.prop('title') ? _this.prop('title') : '新窗口';
    var submit = _this.data('sub') != undefined ? _this.data('sub') : true;

    if (flag_dialog) {
      flag_dialog = false;
      $.get(_this.prop('href'), function (content) {
        if(content.hasOwnProperty('code') && content.code == 300){
          layer.msg(content.msg, function () {
            layer.close();
          });
          flag_dialog = true;
          return false;
        }
        var base_options = {
          type: 1,
          title: title,
          shadeClose: true,
          shade: 0.4,
          area: [width, height],
          content: content,
          end: function () {
            flag_dialog = true;
          }
        };
        var sub_options = {
          btn: ['提交', '取消'],
          yes: function () {
            //var btn = $("button[type='submit']");
            var btn = $("button.J_ajax_submit_btn");
            ajaxSubmitForm(btn);
            flag_dialog = true;
          }
        };

        var options = submit ? $.extend(base_options, sub_options) : base_options;
        layer.open(options);

        flag_dialog = false;
      });
    }
  });
}
/**
 * 列表数据删除
 */
if ($('a.J_layer_dialog_del').length) {
  var flag_del = true;    // 阻止多次点击触发事件
  $('a.J_layer_dialog_del').on('click', function (e) {
    e.preventDefault();
    var _this = $(this);
    var url = _this.prop('href');
    var token = _this.data('token');
    var msg = _this.data('msg') ? _this.data('msg') : '确定要删除吗？';

    if (flag_del) {
      flag_del = false;
      layer.confirm(msg, {
        title: "信息确认",
        btn: ['确定', '取消'],
        end: function () {
          flag_del = true;
        }
      }, function (index) {
        $.post(url, {_method: 'DELETE', _token: token}, function (data) {
          if (data.status == 'success') {
              layer.msg(data.msg, function () {

              });
            window.location.reload();
          } else {
            layer.msg(data.msg, function () {
              layer.close(index);
            });
          }
          flag_del = true;
        });
      }, function () {
        flag_del = true;
      });
    }
  });
}

/**
 * 列表ajax提交
 */
if ($('a.J_layer_ajax').length) {
  var flag_ajax = true;    // 阻止多次点击触发事件
  $('a.J_layer_ajax').on('click', function (e) {
    e.preventDefault(e);
    var _this = $(this);
    var url = _this.prop('href');
    var token = _this.data('token');

    if (flag_ajax) {
      flag_ajax = false;
      $.post(url, {_token: token}, function (data) {
        if (data.status == 'success') {
          layer.msg(data.msg, function () {
            layer.close(index);
          });
          window.location.reload();
        } else {
          layer.msg(data.msg, function () {
            layer.close(index);
          });
        }
        flag_ajax = true;
      });
    }
    return false;
  });
}


// 列表ajax确认提交
if ($('a.J_layer_ajax_confirm').length) {
  var flag_confirm = true;    // 阻止多次点击触发事件
  $('a.J_layer_ajax_confirm').on('click', function (e) {
    e.preventDefault();
    var _this = $(this);
    var url = _this.prop('href');
    var token = _this.data('token');
    var msg = _this.data('msg') ? _this.data('msg') : '确定执行操作吗？';

    if (flag_confirm) {
      flag_confirm = false;
      layer.confirm(msg, {
        title: "信息确认",
        btn: ['确定', '取消'],
        end: function () {
          flag_confirm = true;
        }
      }, function (index) {
        $.post(url, {_token: token}, function (data) {
          if (data.status == 'success') {
            layer.msg(data.msg, function () {
              layer.close(index);
            });
            window.location.reload();
          } else {
            layer.msg(data.msg, function () {
              layer.close(index);
            });
          }
          flag_confirm = true;
        });
      }, function () {
        flag_confirm = true;
      });
    }
  });
}

/**
 * 数据提交前确认
 */
if ($('a.J_layer_dialog_confirm').length) {
  var flag_confirm = true;    // 阻止多次点击触发事件
  $('a.J_layer_dialog_confirm').on('click', function (e) {
    e.preventDefault();
    var _this = $(this);
    var url = _this.prop('href');
    var token = _this.data('token');
    var msg = _this.data('msg') ? _this.data('msg') : '确认提交？';

    if (flag_confirm) {
      flag_confirm = false;
      layer.confirm(msg, {
        icon: 3,
        btn: ['确认', '取消'],
        end: function () {
          flag_confirm = true;
        }
      }, function (index) {
        $.post(url, {_method: 'PUT', _token: token}, function (data) {
          if (data.status == 'success') {
            window.location.reload();
          } else {
            layer.msg(data.msg, function () {
              layer.close(index);
            });
          }
          flag_confirm = true;
        });
      }, function () {
        flag_confirm = true;
      });
    }
  });
}

if ($('.J_check_wrap').length) {
  var total_check_all = $('input.J_check_all');

  //遍历所有全选框
  $.each(total_check_all, function () {
    var check_all = $(this), check_items;

    //分组各纵横项
    var check_all_direction = check_all.data('direction');
    check_items = $('input.J_check[data-' + check_all_direction + 'id="' + check_all.data('checklist') + '"]');

    //点击全选框
    check_all.change(function (e) {
      var check_wrap = check_all.parents('.J_check_wrap'); //当前操作区域所有复选框的父标签（重用考虑）

      if ($(this).prop('checked')) {
        //全选状态
        check_items.prop('checked', true);

        //所有项都被选中
        if (check_wrap.find('input.J_check').length === check_wrap.find('input.J_check:checked').length) {
          check_wrap.find(total_check_all).prop('checked', true);
        }

      } else {
        //非全选状态
        check_items.prop('checked', false);

        //另一方向的全选框取消全选状态
        var direction_invert = check_all_direction === 'x' ? 'y' : 'x';
        check_wrap.find($('input.J_check_all[data-direction="' + direction_invert + '"]')).removeAttr('checked');
      }

    });

    //点击非全选时判断是否全部勾选
    check_items.change(function () {

      if ($(this).prop('checked')) {

        if (check_items.filter(':checked').length === check_items.length) {
          //已选择和未选择的复选框数相等
          check_all.prop('checked', true);
        }

      } else {
        check_all.prop('checked', false);
      }

    });


  });

}


/**
 * 基于ajax的联动下拉选择
 * @type {*|jQuery|HTMLElement}
 */
var ajax_select = $(".J_ajax_select");
if (ajax_select.length) {
  //ajax_select.hide();
  ajax_select.each(function () {
    if ($(this).data('init')) {
      var valId = $(this).data('val');
      valId = $('#' + valId);

      var select = $(this);
      $.get($(this).data('url'), function (rsb) {
        var option = "";
        if (select.data('type') == 'all') {
          option = "<option value=''>全部</option>";
        } else {
          option = "<option value='-1'>请选择</option>";
        }

        for (var i = 0; i < rsb.length; i++) {
          option += '<option value="' + rsb[i].id + '">' + rsb[i].title + '</option>';
        }
        select.html(option);
        select.show();
        if (select.data('value') != '') {
          select.val(select.data('value'));
          select.change();
        }
        valId.val(select.data('value'));

      }, 'json');

    }
    $(this).change(function () {
      var valId = $(this).data('val');
      var select = $(this);
      valId = $('#' + valId);
      var target = $(this).data('target');
      target = $('#' + target);
      if (target.length > 0) {
        var option = "";
        if (target.data('type') == 'all') {
          option = "<option value='" + select.val() + "'>全部</option>";
        } else {
          option = "<option value=''>请选择</option>";
        }
        if (select.val() != '') {
          $.get(target.data('url'), "id=" + select.val(), function (rsb) {
            if (rsb.length > 0) {
              for (var i = 0; i < rsb.length; i++) {
                option += '<option value="' + rsb[i].id + '">' + rsb[i].title + '</option>';
              }
              valId.val('');
              target.show();
            } else {
              valId.val(select.val());
              target.hide();
            }
            target.html(option);
            if (target.val() == undefined || target.val() == '') {
              valId.val(select.val());
            }
            if (target.data('value') != undefined) {
              target.val(target.data('value'));
            }
            target.change();

          }, 'json');
        } else if (select.find('option:selected').text() != '全部') {
          //target.hide();
          target.html(option);
          var prevselect = select.prev().val();
          valId.val(prevselect);
        } else {
          //target.hide();
          valId.val(select.val());
        }
      } else {
        if (select.find('option').length > 1 && !(select.val() == undefined || select.val() == '')) {
          valId.val(select.val());
        } else if (valId.data('type') != 'each') {
          var prevselect = select.prev().val();
          valId.val(prevselect);
        }
      }
    });
  });

}

/**
 * 图片上传
 */
var J_upload_image = $(".J_upload_image");
if (J_upload_image.length) {
  J_upload_image.each(function () {
    var picId = $(this).data('id');
    var picWidth = ($(this).data('width') == '' || $(this).data('width') == undefined) ? 640 : $(this).data('width');
    var url = ($(this).data('url') == '' || $(this).data('url') == undefined) ? window.location.protocol + "//" + window.location.host + '/admin/file/uploadPic' : $(this).data('url');
    var token = $(this).data('_token');
    var type = ($(this).data('type') == 'multiple') ? 'multiple' : 'single';
    var image_val = ($(this).find("input[name='image_val']").val() == undefined) ? '' : $(this).find("input[name='image_val']").val();
    var image_path = [];
    $(this).find("input[name='image_path[]']").each(function () {
      image_path.push([$(this).val(), $(this).data('id')]);
    });

    if (picId != '' && token != '') {
      var ori_image = '';
      if (image_val != '' && image_val != undefined) {
        if (type == 'single') {
          ori_image = '<li onclick="var delimg=$(this);var input=$(\'#' + picId + '\');layer.confirm(\'您确定要删除吗?\',{icon: 3, title:\'提示\',btn:[\'确定\',\'取消\']},function(){delimg.remove();input.val(\'\');layer.msg(\'删除成功\');},function(){});" class="weui_uploader_file weui_uploader_status" style="background-image:url(' + image_path[0][0] + ')">' +
            '<div class="weui_uploader_status_content"><i class="weui_icon_cancel"></i></div></li>';
        } else {
          $.each(image_path, function () {
            ori_image += '<li onclick="var delimg=$(this);var input=$(\'#' + picId + '\');layer.confirm(\'您确定要删除吗?\',{icon: 3, title:\'提示\',btn:[\'确定\',\'取消\']},function(){delimg.remove();var pics = input.val().split(\',\');pics.splice($.inArray(\'' + $(this)[1] + '\',pics),1);input.val(pics.join());layer.msg(\'删除成功\');},function(){});" ' +
              'class="weui_uploader_file weui_uploader_status" style="background-image:url(' + $(this)[0] + ')">' +
              '<div class="weui_uploader_status_content"><i class="weui_icon_cancel"></i></div></li>'
          })
        }
      }

      if (type == 'single') {
        var html = '<div class="weui_uploader_bd"><ul class="weui_uploader_files" id="img_' + picId + '">' + ori_image + '</ul>' +
          '<div class="weui_uploader_input_wrp">' +
          '<input class="weui_uploader_input" type="file" accept="image/jpg,image/jpeg,image/png,image/gif" id="file_' + picId + '" />' +
          '<input  type="hidden"  id="' + picId + '" name="' + picId + '" value="' + image_val + '"/>' +
          '</div></div>';
      } else {
        var num = ($(this).data('num') == '' || $(this).data('num') == undefined) ? 5 : $(this).data('num');
        var html = ' <div class="weui_uploader_bd">' +
          '<ul class="weui_uploader_files" id="img_' + picId + '">' + ori_image + '</ul>' +
          '<div class="weui_uploader_input_wrp" id="input_' + picId + '">' +
          '<input class="weui_uploader_input" type="file" accept="image/jpg,image/jpeg,image/png,image/gif"  id="file_' + picId + '" multiple />' +
          '<input  type="hidden"  id="' + picId + '" name="' + picId + '" value="' + image_val + '"/>' +
          '</div></div>';
      }
      $(this).html(html);
      var f = document.querySelector('#file_' + picId);
      f.onchange = function (e) {
        var files = e.target.files;
        var len = files.length;
        if (type == 'multiple' && ($("#" + picId).val().split(',').length - 1 + len) > num) {
          layer.msg('最多上传' + num + '张图片');
        } else {
          for (var i = 0; i < len; i++) {
            layer.load();
            lrz(this.files[i], {width: picWidth, fieldName: "photo"}).then(function (rst) {
              var xhr = new XMLHttpRequest();
              xhr.open('POST', url);
              xhr.onload = function () {
                if (xhr.status === 200) {
                  var obj = eval('(' + xhr.responseText + ')');
                  if (type == 'single') {
                    $('#img_' + picId).html(
                      '<li onclick="var delimg=$(this);var input=$(\'#' + picId + '\');layer.confirm(\'您确定要删除吗?\',{icon: 3, title:\'提示\',btn:[\'确定\',\'取消\']},function(){delimg.remove();input.val(\'\');layer.msg(\'删除成功\');},function(){});" ' +
                      'class="weui_uploader_file weui_uploader_status" style="background-image:url(' + obj.data.path + ')">' +
                      '<div class="weui_uploader_status_content"><i class="weui_icon_cancel"></i></div></li>');
                    $("#" + picId).val(obj.data.id);
                  } else {
                    $('#img_' + picId).append('<li onclick="var delimg=$(this);var input=$(\'#' + picId + '\');layer.confirm(\'您确定要删除吗?\',{icon: 3, title:\'提示\',btn:[\'确定\',\'取消\']},function(){delimg.remove();var pics = input.val().split(\',\');pics.splice($.inArray(\'' + obj.data.id + '\',pics),1);input.val(pics.join());layer.msg(\'删除成功\');},function(){});" ' +
                      'class="weui_uploader_file weui_uploader_status" style="background-image:url(' + obj.data.path + ')"><div class="weui_uploader_status_content"><i class="weui_icon_cancel"></i></div></li>');
                    $("#" + picId).val($("#" + picId).val() + obj.data.id + ',');
                  }
                  layer.closeAll('loading');
                  layer.msg(obj.msg);
                } else {
                  // 处理其他情况
                }
              };

              xhr.onerror = function () {
                // 处理错误
              };

              xhr.upload.onprogress = function (e) {
                // 上传进度
                var percentComplete = ((e.loaded / e.total) || 0) * 100;
              };

              // 添加参数
              rst.formData.append('size', rst.fileLen);
              rst.formData.append('base64', rst.base64);
              rst.formData.append('_token', token);
              // 触发上传
              xhr.send(rst.formData);

              return rst;
            })
              .catch(function (err) {
                alert(err);
              })

              .always(function () {// 不管是成功失败，这里都会执行
              });
          }
        }

      }
    }
  });
}

