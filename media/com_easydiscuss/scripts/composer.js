EasyDiscuss.module("composer",function(e){var t=this;EasyDiscuss.Controller("Composer",{defaultOptions:{editor:null,"{editor}":".dc_reply_content","{tabs}":".formTabs [data-foundry-toggle=tab]","{form}":"form[name=dc_submit]","{attachments}":"input.fileInput","{saveButton}":".save-reply","{cancelButton}":".cancel-reply","{notification}":".replyNotification"}},function(e){return{init:function(){e.id=e.element.attr("data-id");var t=e.element.attr("data-editor")||e.options.editor;t=="bbcode"&&EasyDiscuss.require().library("markitup","autogrow").done(function(t){e.editor().markItUp({set:"bbcode_easydiscuss"}).autogrow({lineBleed:1})}),e.tabs(":first").tab("show"),EasyDiscuss.module(e.id,function(){this.resolve(e)})},"{saveButton} click":function(){e.save()},"{cancelButton} click":function(){e.trigger("cancel")},save:function(){var t=e.form().serializeJSON();t.content=t.dc_reply_content,t.files=e.attachments(),EasyDiscuss.ajax("site.views.post.saveReply",t,{type:"iframe",reloadCaptcha:function(){Recaptcha.reload()}}).done(function(t){e.trigger("save",t)}).fail(function(t,n){console.log(arguments),console.log(e.notification()),e.notification().addClass("alert-"+t).html(n).show()})}}}),t.resolve()});