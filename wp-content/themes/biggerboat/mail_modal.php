<!-- sample modal content -->
<div id="modal-from-dom" class="modal hide fade">
    <div class="modal-header">
        <a href="#" class="close">&times;</a>
        <h3>Need help? Send us a message!</h3>
    </div>
    <div class="modal-body">
        <span class="help-block black">Include details like <strong>project description</strong>, <strong>start of production</strong>, <strong>deadlines</strong> and of course the <strong>skills</strong> you're looking for.<br>We will handle your information discreetly and (most probably) not sell it to Nigerian scam pirates.</span>
        <br>
        <form id="contactForm">
            <?php wp_nonce_field('bigger_boat_mail', 'nounce'); ?>
            <div class="row">
                <div class="span5">
                    <label for="name">Name</label>
                    <div class="input">
                        <input class="xlarge required" id="name" name="name" size="30" type="text">
                    </div>
                    <br>
                    <label for="email">Email</label>
                    <div class="input">
                        <input class="xlarge required email" id="email" name="email" size="30" type="text">
                    </div>
                    <br>
                    <span class="help-block black">
                       Need help asap? Enter your phone number below. One of us will call you back during office hours.
                    </span>
                    <br>
                    <label for="email">Phone</label>
                    <div class="input">
                        <input class="xlarge" id="phone" name="phone" size="30" type="text">
                    </div>
                </div>
                <div class="span6">
                    <label for="subject">Subject</label>
                    <div class="input">
                        <input class="xlarge required longer" id="subject" name="subject" size="30" type="text">
                    </div>
                    <br>
                    <div class="clearfix">
                        <label for="details">Details</label>
                        <div class="input">
                            <textarea class="xlarge required" id="details" name="details" rows="3"></textarea>
                            <span class="help-block">
                                Be as specific as you can!
                            </span>
                        </div>
                    </div>
                      <label>
                        <input type="checkbox" id="recruiter">
                        Text for checkbox
                      </label>
                    <div>
                    </div>
                </div>
            </div>
            <div style="text-align: right;">
                <a class="btn large disabled" id="submit_mail">Aye, send message!</a>
            </div>
        </form>
    </div>
</div>
