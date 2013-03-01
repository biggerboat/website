class BiggerBoat


	constructor: () ->
		@numberOfActivities = 0

		@toggleSubinput()
		@updateActivity()
		@initialize()

		# do initial vote? based on vote param?
		get_vars = @getUrlVars()
		if get_vars.hasOwnProperty 'vote'
			@vote_by_url = true
			if (get_vars.vote is '1')
				(jQuery 'input:radio[name="interested"][value="1"]').get(0).checked = true
				(jQuery 'input:radio[name="interested"][value="1"]').trigger 'click'

			if (get_vars.vote is '0')
				(jQuery 'input:radio[name="interested"][value="0"]').get(0).checked = true
				(jQuery 'input:radio[name="interested"][value="0"]').trigger 'click'


	initialize: ->
		data = {}
		scope = this

		(jQuery 'input:checkbox[name="job-contact-client"]').click ->
			data = scope.createDataObject()
			data.activityText = if (jQuery this).is(':checked') then "contacted the client" else "changed his mind about contacting the client"
			data.userId = (jQuery this).closest('td').find('input:hidden[name="user_id"]').val()

			scope.showLabel.apply (jQuery this)
			scope.postActivity data

		(jQuery 'input:checkbox[name="job-got-job"]').click ->
			data = scope.createDataObject()
			data.activityText = if (jQuery this).is(':checked') then "got the job" else "changed his mind about getting the job"
			data.userId = (jQuery this).closest('td').find('input:hidden[name="user_id"]').val()

			scope.showLabel.apply (jQuery this)
			scope.postActivity data

		(jQuery 'input:checkbox[name="job-contact-client-decline"]').click ->
			data = scope.createDataObject()
			data.activityText = if (jQuery this).is(':checked') then "mail sent to client that no one is interested" else "changed his mind about sending mail that no one is interested"
			data.userId = (jQuery this).closest('td').find('input:hidden[name="user_id"]').val()

			scope.showLabel.apply (jQuery this)
			scope.postActivity data

		jQuery('input:radio[name="interested"][value="1"], input:radio[name="interested"][value="0"]').click ->
			data = scope.createDataObject()
			data.activityText = if (jQuery this).val() is '1' then 'is interested' else 'is not interested'
			data.userId = (jQuery this).closest('td').find('input:hidden[name="user_id"]').val()

			scope.showLabel.apply (jQuery this)
			scope.toggleSubinput()
			scope.postActivity data

		@

	createDataObject: ->
		interested:      jQuery('input:radio[name="interested"]:checked').val()
		contactedClient: if (jQuery 'input:checkbox[name="job-contact-client"]').is(":checked") then '1' else '0'
		gotJob:          if (jQuery 'input:checkbox[name="job-got-job"]').is(":checked") then '1' else '0'
		declineJob:      if (jQuery 'input:checkbox[name="job-contact-client-decline"]').is(":checked") then '1' else '0'
		postId:          (jQuery 'input[name="post_id"]').val()


	postActivity: (data) ->
		data.action = 'bigger_boat_jobs_submit_vote'
		jQuery.post ajaxurl, data, jQuery.proxy @updateActivity, @

	toggleSubinput: ->
		subinput1 = (jQuery 'input:radio[name="interested"][value="1"]').parents('li').find '.subinput'
		subinput2 = (jQuery 'input:radio[name="interested"][value="0"]').parents('li').find '.subinput'

		if (jQuery 'input:radio[name="interested"]:checked').val() is '1'
			subinput1.slideDown 'fast'
			subinput2.slideUp 'fast'
		else
			subinput2.slideDown 'fast'
			subinput1.slideUp 'fast'

	showLabel: ->
		label = (jQuery this).closest 'label'
		label.append '''
			<div class="twipsy right">
				<div class="twipsy-arrow"></div>
				<div class="twipsy-inner">saved</div>
			</div>
		'''
		twipsy = (jQuery label).find '.twipsy'
		twipsy.delay(2000).fadeOut 'slow', (-> jQuery(this).remove())

	updateActivity: ->
		vars = action: 'bigger_boat_jobs_get_activity_log', postId: (jQuery 'input[name="post_id"]').val()
		jQuery.post ajaxurl, vars, (data) =>

			# add to DOM
			(jQuery '#activity').html data

			if (@numberOfActivities is 0)
				# nu activities found, just slide the activity container down
				(jQuery '#activity').hide().slideDown 'slow'
			else
				# there are already activities found, only slide down who's recently added
				(jQuery '#activity ul li').each (index, item) => (jQuery item).hide().slideDown('fast') if index > @numberOfActivities - 1

			# update the number of activities
			@numberOfActivities = (jQuery '#activity ul li').length

			# scroll to saved when var param vote is set
			if @vote_by_url
				@vote_by_url = false
				setTimeout (=>
					(jQuery 'html, body').animate {scrollTop: (jQuery '#activity li:last').offset().top }, 500
				), 500


	getUrlVars: ->
		vars = {}
		loc = window.location.href
		hashes = loc.slice(loc.indexOf('?') + 1).split '&'
		for hash in hashes
			h = hash.split '='
			vars[h[0]] = h[1]
		vars


jQuery -> new BiggerBoat()