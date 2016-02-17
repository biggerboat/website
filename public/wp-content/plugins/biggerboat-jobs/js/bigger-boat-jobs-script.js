(function() {
  var BiggerBoat;

  BiggerBoat = (function() {

    function BiggerBoat() {
      var get_vars;
      this.numberOfActivities = 0;
      this.toggleSubinput();
      this.updateActivity();
      this.initialize();
      get_vars = this.getUrlVars();
      if (get_vars.hasOwnProperty('vote')) {
        this.vote_by_url = true;
        if (get_vars.vote === '1') {
          (jQuery('input:radio[name="interested"][value="1"]')).get(0).checked = true;
          (jQuery('input:radio[name="interested"][value="1"]')).trigger('click');
        }
        if (get_vars.vote === '0') {
          (jQuery('input:radio[name="interested"][value="0"]')).get(0).checked = true;
          (jQuery('input:radio[name="interested"][value="0"]')).trigger('click');
        }
      }
    }

    BiggerBoat.prototype.initialize = function() {
      var data, scope;
      data = {};
      scope = this;
      (jQuery('input:checkbox[name="job-contact-client"]')).click(function() {
        data = scope.createDataObject();
        data.activityText = (jQuery(this)).is(':checked') ? "contacted the client" : "changed his mind about contacting the client";
        data.userId = (jQuery(this)).closest('td').find('input:hidden[name="user_id"]').val();
        scope.showLabel.apply(jQuery(this));
        return scope.postActivity(data);
      });
      (jQuery('input:checkbox[name="job-got-job"]')).click(function() {
        data = scope.createDataObject();
        data.activityText = (jQuery(this)).is(':checked') ? "got the job" : "changed his mind about getting the job";
        data.userId = (jQuery(this)).closest('td').find('input:hidden[name="user_id"]').val();
        scope.showLabel.apply(jQuery(this));
        return scope.postActivity(data);
      });
      (jQuery('input:checkbox[name="job-contact-client-decline"]')).click(function() {
        data = scope.createDataObject();
        data.activityText = (jQuery(this)).is(':checked') ? "mail sent to client that no one is interested" : "changed his mind about sending mail that no one is interested";
        data.userId = (jQuery(this)).closest('td').find('input:hidden[name="user_id"]').val();
        scope.showLabel.apply(jQuery(this));
        return scope.postActivity(data);
      });
      jQuery('input:radio[name="interested"][value="1"], input:radio[name="interested"][value="0"]').click(function() {
        data = scope.createDataObject();
        data.activityText = (jQuery(this)).val() === '1' ? 'is interested' : 'is not interested';
        data.userId = (jQuery(this)).closest('td').find('input:hidden[name="user_id"]').val();
        scope.showLabel.apply(jQuery(this));
        scope.toggleSubinput();
        return scope.postActivity(data);
      });
      return this;
    };

    BiggerBoat.prototype.createDataObject = function() {
      return {
        interested: jQuery('input:radio[name="interested"]:checked').val(),
        contactedClient: (jQuery('input:checkbox[name="job-contact-client"]')).is(":checked") ? '1' : '0',
        gotJob: (jQuery('input:checkbox[name="job-got-job"]')).is(":checked") ? '1' : '0',
        declineJob: (jQuery('input:checkbox[name="job-contact-client-decline"]')).is(":checked") ? '1' : '0',
        postId: (jQuery('input[name="post_id"]')).val()
      };
    };

    BiggerBoat.prototype.postActivity = function(data) {
      data.action = 'bigger_boat_jobs_submit_vote';
      return jQuery.post(ajaxurl, data, jQuery.proxy(this.updateActivity, this));
    };

    BiggerBoat.prototype.toggleSubinput = function() {
      var subinput1, subinput2;
      subinput1 = (jQuery('input:radio[name="interested"][value="1"]')).parents('li').find('.subinput');
      subinput2 = (jQuery('input:radio[name="interested"][value="0"]')).parents('li').find('.subinput');
      if ((jQuery('input:radio[name="interested"]:checked')).val() === '1') {
        subinput1.slideDown('fast');
        return subinput2.slideUp('fast');
      } else {
        subinput2.slideDown('fast');
        return subinput1.slideUp('fast');
      }
    };

    BiggerBoat.prototype.showLabel = function() {
      var label, twipsy;
      label = (jQuery(this)).closest('label');
      label.append('<div class="twipsy right">\n	<div class="twipsy-arrow"></div>\n	<div class="twipsy-inner">saved</div>\n</div>');
      twipsy = (jQuery(label)).find('.twipsy');
      return twipsy.delay(2000).fadeOut('slow', (function() {
        return jQuery(this).remove();
      }));
    };

    BiggerBoat.prototype.updateActivity = function() {
      var vars,
        _this = this;
      vars = {
        action: 'bigger_boat_jobs_get_activity_log',
        postId: (jQuery('input[name="post_id"]')).val()
      };
      return jQuery.post(ajaxurl, vars, function(data) {
        (jQuery('#activity')).html(data);
        if (_this.numberOfActivities === 0) {
          (jQuery('#activity')).hide().slideDown('slow');
        } else {
          (jQuery('#activity ul li')).each(function(index, item) {
            if (index > _this.numberOfActivities - 1) {
              return (jQuery(item)).hide().slideDown('fast');
            }
          });
        }
        _this.numberOfActivities = (jQuery('#activity ul li')).length;
        if (_this.vote_by_url) {
          _this.vote_by_url = false;
          return setTimeout((function() {
            return (jQuery('html, body')).animate({
              scrollTop: (jQuery('#activity li:last')).offset().top
            }, 500);
          }), 500);
        }
      });
    };

    BiggerBoat.prototype.getUrlVars = function() {
      var h, hash, hashes, loc, vars, _i, _len;
      vars = {};
      loc = window.location.href;
      hashes = loc.slice(loc.indexOf('?') + 1).split('&');
      for (_i = 0, _len = hashes.length; _i < _len; _i++) {
        hash = hashes[_i];
        h = hash.split('=');
        vars[h[0]] = h[1];
      }
      return vars;
    };

    return BiggerBoat;

  })();

  jQuery(function() {
    return new BiggerBoat();
  });

}).call(this);
