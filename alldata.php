<?php
	require_once 'db.php';
	dbConnect('dokhlab');
	//$db_to_use = "vdesign";
	$author_table = "members";
	$publication_table = "publications";
	$db_selected = mysql_select_db($db_to_use,$link);
	$get_authors = "SELECT * FROM $author_table";
	$author_list = mysql_query($get_authors);
	if (!$author_list) {
 		echo "$get_authors\t$author_list";
	}
	$authcnt=0;
	while($row=mysql_fetch_array($author_list)) {
		$fname = mysql_real_escape_string($row[ 'f_name']);
 		$minit = mysql_real_escape_string($row[ 'm_init']);
 		$lname = mysql_real_escape_string($row[ 'l_name']);
 		$pubauthors["$fname $minit $lname"]="";
 		$auth_pub_cnt["$fname $minit $lname"]=0;
 		$author_lnames["$lname"]="$fname $minit $lname";
	}
	$get_all = "SELECT * FROM $publication_table ORDER BY year DESC";
	$all_pubs = mysql_query($get_all);
	$bookcnt=$confcnt=$rescnt=0;
	$paper_results=array();
	$book_results=array();
	$conf_results=array();
	$filtervals=array();
	$updated_results=array();
	$u_papers=array();
	$u_books =array();
	$u_confs =array();
	while($row=mysql_fetch_array($all_pubs)) {
 		$pub_id      = mysql_real_escape_string($row[ 'pub_id']);
 		$pub_code    = mysql_real_escape_string($row[ 'code']);
 		$pub_authors = mysql_real_escape_string($row[ 'authors']);
 		$pub_journal = mysql_real_escape_string($row[ 'publ_in']);
 		$pub_title   = mysql_real_escape_string($row[ 'title']);
 		$pub_voliss  = mysql_real_escape_string($row[ 'vol_iss']);
 		$pub_year    = mysql_real_escape_string($row[ 'year']);
 		$pub_type    = mysql_real_escape_string($row[ 'type']);
 		$pub_editors = mysql_real_escape_string($row[ 'editors']);
		 if($pub_type == "book") {
	 		$pubtypes["Book Chapters"] = 0;
	 		$books[ $bookcnt]          = "$pub_authors, \"$pub_title\" in <i>$pub_journal</i>, $pub_voliss, ($pub_year) Editors: $pub_editors<br>";
			$book_titles[ $bookcnt]    = $pub_title;
			$book_journals[ $bookcnt]  = $pub_journal;
			$book_authors[ $bookcnt]   = $pub_authors;
	 		$pubyears[$pub_year]      .= "$books[$bookcnt]<br>";
	 		foreach ( $author_lnames as $author_lname=>$author_name ):
		 		if ( preg_match("/$author_lname/",$pub_authors) ):
			 		$pubauthors["$author_name"].="$books[$bookcnt]<br>";
			 		$pubcount["$author_name"]++;
		 		endif;
	 		endforeach;
	 		$bookcnt++;
 		} else if($pub_type == "conference") {
	 		$pubtypes["Conference Proceedings"] = 0;
	 		$confs[ $confcnt]                   = "$pub_authors, \"$pub_title\", <i>$pub_journal</i>, $pub_voliss, ($pub_year)<br>";
			$conf_titles[ $confcnt]             = $pub_title;
			$conf_journals[ $confcnt]           = $pub_journal;
			$conf_authors[ $confcnt]            = $pub_authors;
	 		$pubyears[$pub_year].="$confs[$confcnt]<br>";
	 		foreach ( $author_lnames as $author_lname=>$author_name ):
		 		if ( preg_match("/$author_lname/",$pub_authors ) ):
			 		$pubauthors["$author_name"].="$papers[$rescnt]<br>";
			 		$pubcount["$author_name"]++;
		 		endif;
	 		endforeach;
	 		$confcnt++;
		} else {
	 		$pubtypes["Research Publications"]  = 0;
	 		$fields = explode(":",$pub_voliss);
	 		$papers[ $rescnt]                   = "$pub_authors, \"$pub_title\", <i>$pub_journal</i>, $fields[0]:$fields[1], ($pub_year)<br>";
			$paper_titles[ $rescnt]             = $pub_title;
			$paper_journals[ $rescnt]           = $pub_journal;
			$paper_authors[ $rescnt]            = $pub_authors;
	 		$pubjournals[$pub_journal].="$papers[$rescnt]<br>";
	 		$jrnl_pub_cnt["$pub_journal"]++;
			 $pubyears[$pub_year].="$papers[$rescnt]<br>";
			 $year_pub_cnt["$pub_year"]++;
			 foreach ( $author_lnames as $author_lname=>$author_name ):
		 		if ( preg_match("/$author_lname/",$pub_authors ) ):
			 		$pubauthors["$author_name"].="$papers[$rescnt]<br>";
			 		$auth_pub_cnt["$author_name"]++;
				 endif;
			 endforeach;
		 	$rescnt++;
 		}
	}
	function retrieveSearch($search_string, $search_category) {
		global $paper_titles, $book_titles, $conf_titles, $paper_journals, $book_journals, $conf_journals, $paper_authors, $book_authors, $conf_authors, $papers, $books, $confs, $paper_results, $book_results, $conf_results;
		$strong_search_string="<strong>".$search_string."</strong>";
		if ( $search_category == "Titles" ) {
			for ( $i=0; $i<count($paper_titles); $i++ ) {
				if ( preg_match(" /$search_string/i", $paper_titles[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $papers[$i]);
					array_push($paper_results, $tmp);
				}
			}
			for ( $i=0; $i<count($book_titles); $i++ ) {
				if ( preg_match(" /$search_string/i", $book_titles[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $books[$i]);
					array_push($book_results, $tmp);
				}
			}
			for ( $i=0; $i<count($conf_titles); $i++ ) {
				if ( preg_match( "/$search_string/i", $conf_titles[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $confs[$i]);
					array_push($conf_results, $tmp);
				}
			}
		} elseif ( $search_category == "Journals" ) {
			for ( $i=0; $i<count($paper_journals); $i++ ) {
				if ( preg_match( "/$search_string/i", $paper_journals[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $papers[$i]);
					array_push($paper_results, $tmp);
				}
			}
			for ( $i=0; $i<count($book_journals); $i++ ) {
				if ( preg_match( "/$search_string/i", $book_journals[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $books[$i]);
					array_push($book_results, $tmp);
				}
			}
			for ( $i=0; $i<count($conf_journals); $i++ ) {
				if ( preg_match( "/$search_string/i", $conf_journals[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $confs[$i]);
					array_push($conf_results, $tmp);
				}
			}
		} elseif ( $search_category == "Authors" ) {
			for ( $i=0; $i<count($paper_authors); $i++ ) {
				if ( preg_match( "/\b$search_string\b/i", $paper_authors[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $papers[$i]);
					array_push($paper_results, $tmp);
				}
			}
			for ( $i=0; $i<count($book_authors); $i++ ) {
				if ( preg_match( "/\b$search_string\b/i", $book_authors[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $books[$i]);
					array_push($book_results, $tmp);
				}
			}
			for ( $i=0; $i<count($conf_authors); $i++ ) {
				if ( preg_match( "/\b$search_string\b/i", $conf_authors[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $confs[$i]);
					array_push($conf_results, $tmp);
				}
			}
		} else {
			for ( $i=0; $i<count($papers); $i++ ) {
				if ( preg_match( "/$search_string/i", $papers[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $papers[$i]);
					array_push($paper_results, $tmp);
				}
			}
			for ( $i=0; $i<count($books); $i++ ) {
				if ( preg_match( "/$search_string/i", $books[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $books[$i]);
					array_push($book_results, $tmp);
				}
			}
			for ( $i=0; $i<count($confs); $i++ ) {
				if ( preg_match( "/$search_string/i", $confs[$i] ) ) {
					$tmp=str_replace($search_string, $strong_search_string, $confs[$i]);
					array_push($conf_results, $tmp);
				}
			}
		}
	}
	function updateSearch($filters, $search_string, $search_category) {
		global $u_papers, $u_books, $u_confs, $auth_pub_cnt, $jrnl_pub_cnt, $year_pub_cnt, $author_lnames, $papers;
		$filterids = split(",",rtrim($filters,","));
		$fil_auths=array();
		$fil_jrnls=array();
		$fil_years=array();
		foreach ($filterids as $fid):
			if ( strpos($fid,'auth')>0 ) {
				$tmp_array=array_keys($auth_pub_cnt);
				array_push($fil_auths,array_search($tmp_array[substr($fid,8)],$author_lnames));
			}
			if ( strpos($fid,'jrnl')>0 ) {
				$tmp_array=array_keys($jrnl_pub_cnt);
				array_push($fil_jrnls,$tmp_array[substr($fid,8)]);
			}
			if ( strpos($fid,'year')>0 ) {
				$tmp_array=array_keys($year_pub_cnt);
				array_push($fil_years,$tmp_array[substr($fid,8)]);
			}
		endforeach;
		#foreach ($fil_auths as $fa):	
		#	echo $fa;
		#endforeach;
		#foreach ($fil_jrnls as $fj):
		#	echo $fj;
		#endforeach;
		#foreach ($fil_years as $fy):
		#	echo $fy;
		#endforeach;
		if ( count($fil_auths)==0 ) {
			$fil_auths=array_keys($author_lnames);
			$authflag=1;
		}
		if ( count($fil_jrnls)==0 ) {
			$fil_jrnls=array_keys($jrnl_pub_cnt);
			$jrnlflag=1;
		}
		if ( count($fil_years)==0 ) {
			$fil_years=array_keys($year_pub_cnt);
			$yearflag=1;
		}
		if ( trim($search_string) != "" ) {
			retrieveSearch($search_string, $search_category);
			global $paper_results, $book_results, $conf_results;
			foreach ($paper_results as $paper):
				foreach ($fil_auths as $sel_auth):
					if(preg_match("/$sel_auth/",$paper)){
						foreach ($fil_jrnls as $sel_jrnl):
							if(preg_match("/$sel_jrnl/",$paper)) {
								foreach($fil_years as $sel_year):
									if(preg_match("/$sel_year/",$paper)) {
										$strong_authfil="<strong>".$sel_auth."</strong>";
										$strong_jrnlfil="<strong>".$sel_jrnl."</strong>";
										$strong_yearfil="<strong>".$sel_year."</strong>";
										if ( $authflag!=1 ) {
											$replauth=str_replace($sel_auth,$strong_authfil,$paper);
											if ( $jrnlflag!=1 ) {
												$repljrnl=str_replace($sel_jrnl,$strong_jrnlfil,$replauth);
												if ( $yearflag!=1 ) {
													$replyear=str_replace($sel_year,$strong_yearfil,$repljrnl);
													$u_papers[$replyear]=0;
												} else {
													$u_papers[$repljrnl]=0;
												}
											} else {
												if ( $yearflag!=1 ) {
													$replyear=str_replace($sel_year,$strong_yearfil,$replauth);
													$u_papers[$replyear]=0;
												} else {
													$u_papers[$replauth]=0;
												}
											}
										} else {
											if ( $jrnlflag!=1 ) {
												$repljrnl=str_replace($sel_jrnl,$strong_jrnlfil,$paper);
												$u_papers[$repljrnl]=0;
											} else {
												$u_papers[$paper]=0;
											}
										}
									}
								endforeach;
							}
						endforeach;
					}
				endforeach;
			endforeach;
		} else {
			foreach ($papers as $paper):
				foreach ($fil_auths as $sel_auth):
					if(preg_match("/$sel_auth/",$paper)){
						foreach ($fil_jrnls as $sel_jrnl):
							if(preg_match("/$sel_jrnl/",$paper)) {
								foreach($fil_years as $sel_year):
									if(preg_match("/$sel_year/",$paper)) {
										$strong_authfil="<strong>".$sel_auth."</strong>";
										$strong_jrnlfil="<strong>".$sel_jrnl."</strong>";
										$strong_yearfil="<strong>".$sel_year."</strong>";
										if ( $authflag!=1 ) {
											$replauth=str_replace($sel_auth,$strong_authfil,$paper);
											if ( $jrnlflag!=1 ) {
												$repljrnl=str_replace($sel_jrnl,$strong_jrnlfil,$replauth);
												if ( $yearflag!=1 ) {
													$replyear=str_replace($sel_year,$strong_yearfil,$repljrnl);
													$u_papers[$replyear]=0;
												} else {
													$u_papers[$repljrnl]=0;
												}
											} else {
												if ( $yearflag!=1 ) {
													$replyear=str_replace($sel_year,$strong_yearfil,$replauth);
													$u_papers[$replyear]=0;
												} else {
													$u_papers[$replauth]=0;
												}
											}
										} else {
											if ( $jrnlflag!=1 ) {
												$repljrnl=str_replace($sel_jrnl,$strong_jrnlfil,$paper);
												$u_papers[$repljrnl]=0;
											} else {
												$u_papers[$paper]=0;
											}
										}
									}
								endforeach;
							}
						endforeach;
					}
				endforeach;
			endforeach;
		}
		#global $filtervals, $paper_journals, $book_journals, $conf_journals, $paper_authors, $book_authors, $conf_authors, $papers, $books, $confs;
	}
	mysql_close($link);
?>
