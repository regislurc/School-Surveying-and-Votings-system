<?php
	include_once "setup.php";
	//File includes functions definition

	class HTML{
		//Class with several HTML rendering
		function candidates($category, $options=''){
			//Getting candidates in a category
			$candidates = getCandidates($category);

			if($candidates){
				//Going to print these guys
				//Getting the categories
				$cats = array_keys($candidates);

				?><div class="row"><?php

				foreach ($candidates as $cat => $cands) {
					?>						
					<div class="col-md-4">
						<div class="card">
							<div class="card-block">
								<p class="card-title"><?php echo $cat; ?></p>
								<ul class="list-group list-group-flush">
									<?php
										//Looping through candidates in this category
										for($n=0; $n<count($cands); $n++){
											$current_cand = $cands[$n];
											?>
												<li class="list-group-item"><?php echo $current_cand['fname']." ".$current_cand['lname']." - <i class='text-muted'><small>".$current_cand['class'].'</small></i>'; ?></li>
											<?php											
										}
									?>
								</ul>
							</div>
						</div>
					</div>						
					<?php
				}
				?></div><?php
				
			}else{
				//No candidates
			}
		}
		function candVote($voters, $class){
			//Getting candidates in a category
			$candidates = getCandidates('%');

			if($candidates){
				//Going to print these guys
				//Getting the categories
				$cats = array_keys($candidates);

				?><form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" id='voteForm'>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<div class="inline-child">
									<label for="inputSID">Student ID</label>
							    	<input type="text" <?php echo array_keys($voters, 'demo')?"disabled value='Demo'":''; ?> class="form-control" id="inputSID" aria-describedby="sidhelp" placeholder="Enter ID">
								</div>
								
							    <small id="sidhelp" class="form-text text-muted">Please enter your ID properly as given.
							    <p>Find your ID on student card, report or request it from administration</p>
							    <p>If you can't finally get it, please seek assistance from head teacher</p>
							    </small>
							</div>
						</div>
					
				<?php

					foreach ($candidates as $cat => $cands) {
						?>						
						<div class="col-md-4">
							<div class="card catcard">
								<div class="card-block">
									<p class="card-title"><?php echo $cat; ?></p>
									<ul class="list-group list-group-flush">
										<?php
											//Looping through candidates in this category
											for($n=0; $n<count($cands); $n++){
												$current_cand = $cands[$n];
												?>
													<li class="list-group-item candli">
														<label class="custom-control custom-radio">
															<input id="<?php echo $cat.''.$current_cand['id'] ?>" name="<?php echo $cat; ?>" type="radio" class="custom-control-input">
															<span class="custom-control-indicator"></span>
															<span class="custom-control-description"><?php echo $current_cand['fname']." ".$current_cand['lname']." - <i class='text-muted'><small>".$current_cand['class'].'</small></i>'; ?></span>
														</label>
													</li>
												<?php											
											}
										?>
										<li class="list-group-item">
											<label class="custom-control custom-radio">
												<input id="<?php echo $cat.'-none'; ?>" name="<?php echo $cat; ?>" type="radio" class="custom-control-input">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description">None</span>
											</label>
										</li>
									</ul>
								</div>
							</div>
						</div>						
						<?php
					}
				?>
						<div class="col-sm-12">
							<button class="btn btn-primary" type="submit">Vote!</button>
						</div>
					</div>
					
				</form><?php
				
			}else{
				//No candidates
			}

		}
		function VoteModal(){
			?>
				<div class="modal fade" id="ComfirmVote">
				  	<div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
						    <h5 class="modal-title">Comfirm your vote, <span class="fill-inName"></span></h5>
						    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						      <span aria-hidden="true">&times;</span>
						    </button>
						  </div>
						  <div class="modal-body">
						  	<p>Contact: <b><i class="fill-phone"></i></b></p>
						  	<form>
						  		<div class="form-group">
						  			Your name: <input type="text" class="form-control" id="name" required>
						  		</div>
						  		<div class="form-group">
						  			Contact phone: <input type="text" class="form-control" id="phone" required>
						  		</div>
						  		<div class="form-group">				      		
						  			<textarea class="form-control" id="message" placeholder="Tell us what you need to recycle or just message" rows="5"></textarea>
						  		</div>
						  	</form>
						  	<p class="text-danger errorlog"></p>

						  	<div class="send-stat" style="display: none;">
						  		<p class="send-text-stat">Sending message</p>
						  		<div id="loader">
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="dot"></div>
									<div class="lading"></div>
								</div>
						  	</div>

						  	

						    <p><i>The industry will contact you for your queries sooner</i></p>
						  </div>
						  <div class="modal-footer">
						    <button type="button" class="btn btn-primary sendmsg-btn">Send</button>
						    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						  </div>
						</div>
				  	</div>
				</div>
			<?php
		}
	}

	function getCandidates($category){
		global $conn;


		if($category == '*') $category = '%';

		//Checking if we are looking for many categories
		if(is_array($category)){
			$tempcat = implode("' OR category LIKE '", $category);
			$category = $tempcat;
		}
		$category = "'".$category."'";

		$query = "SELECT * FROM candidate WHERE category LIKE $category";

		$query = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$cands = array();
		while ($data = mysqli_fetch_assoc($query)) {
			if(empty($cands[$data['category']])) $cands[$data['category']] = array();

			$cands[$data['category']][] = array_merge($cands[$data['category']], $data);
		}
		return $cands;
	}
	$HTML =  new HTML();
?>