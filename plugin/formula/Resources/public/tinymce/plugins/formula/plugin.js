(function () {
  'use strict';
  var tinymce = window.tinymce;
  tinymce.PluginManager.requireLangPack('formula', 'en,es,fr_FR');
  tinymce.PluginManager.add('formula', function (editor, url) {
    function showFormulaDialog() {
      var currentNode = editor.selection.getNode();

      function getFrame() {
        var lang = editor.settings.language || "en";
        var mlangParam = "";
        var equationParam = "";
        if (currentNode.nodeName.toLowerCase() == "img" && currentNode.className.indexOf("fm-editor-equation") > -1) {
          if (currentNode.getAttribute("data-mlang")) mlangParam = "&mlang=" + currentNode.getAttribute("data-mlang");
          if (currentNode.getAttribute("data-equation")) equationParam = "&equation=" + currentNode.getAttribute("data-equation");
        }
        var html = '<iframe name="tinymceFormula" id="tinymceFormula" src="' + url + '/index.html' + '?lang=' + lang + mlangParam + equationParam + '" scrolling="yes" frameborder="0"></iframe>';
        return html;
      };
      win = editor.windowManager.open({
        title: "Formula",
        width: 900,
        height: 510,
        html: getFrame(),
        buttons: [
          {
            text: 'Cancel',
            onclick: function () {
              this.parent().parent().close();
            }
          },

          {
            text: 'Insert Formula',
            subtype: 'primary',
            onclick: function (e) {
              var me = this;
              if (window.frames['tinymceFormula'] && window.frames['tinymceFormula'].getData) {
                window.frames['tinymceFormula'].getData(function (src, mlang, equation) {
                  if (src) {
                    editor.insertContent('<img class="fm-editor-equation" src="' + src + '" data-mlang="' + mlang + '" data-equation="' + encodeURIComponent(equation) + '"/>');
                  }
                  me.parent().parent().close();
                });
              } else {
                me.parent().parent().close();
              }
            }
          }
        ]
      });
    }

    editor.addButton('formula', {
      image: url + '/img/formula.png',
      tooltip: 'Insert Formula',
      onclick: showFormulaDialog,
      onPostRender: function () {
        var _this = this;   // reference to the button itself
        editor.on('NodeChange', function (e) {
          _this.active(e.element.className.indexOf('fm-editor-equation') > -1 && e.element.nodeName.toLowerCase() == "img");
        })
      }
    });
  });
}());
