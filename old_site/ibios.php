<?php
	class Bios {
		private $headerfolder, $bPic, $bName, $bInfo, $bBio;
		
		function __construct($headerfolder) {
			$this->headerfolder = $headerfolder;
			$this->bPic = array();
			$this->bName = array();
			$this->bInfo = array();
			$this->bBio = array();
			
			$this->bPic['diane'] = 'diane.png';
			$this->bName['diane'] = 'Diane Kim';
			$this->bInfo['diane'] = 'Br &rsquo;16, Founder';
			$this->bBio['diane'] = 'Like the average college student, Diane Kim enjoys spending absurd amounts of time obsessing over cat memes, tagging everything as #foodporn, and reaching enlightenment from twenty-something articles. She co-founded The Boola in hopes of providing Yale students yet another opportunity to put off those Econ problem sets and dreaded English papers and instead exercise their skills in procrastination by scrolling through this website. During her free time, she is a Political Science major, a sappy pianist, and human rights advocate. Her life goal is to return to her home state California for the warmth, the beaches, the Taco Tuesday deals, and the In N Out milkshakes.';
			
			$this->bPic['qingyang'] = 'qingyang.png';
			$this->bName['qingyang'] = 'Qingyang Chen';
			$this->bInfo['qingyang'] = 'Sm &rsquo;17, Founder';
			$this->bBio['qingyang'] = 'Qingyang Chen, better known as &ldquo;Q&rdquo;, wants to provide the Yale community with a news hub of articles and information pertinent to everyday life. Q&rsquo;s main aspiration is for world peace, one tech movement at a time. He actively participates in several campus organizations including the Asian American Students Alliance, the Yale Daily News, the Photography Society, and the Yale Undergraduate Consulting Group. During Q&rsquo;s nonexistent spare time, he enjoys dancing and making videos.';
			
			$this->bPic['maggie'] = 'maggie.png';
			$this->bName['maggie'] = 'Maggie Green';
			$this->bInfo['maggie'] = 'Je &rsquo;14, Writer';
			$this->bBio['maggie'] = 'Maggie Green&rsquo;s lawyer, er, publicist, forbid her from sharing any personal information about herself.  You can read about her story in her upcoming book, &ldquo;Dance, Film, Science, Ninjas, Zombies, and more Dance: the Maggie Green Story.&rdquo;
			<br />
			Maggie Green is not affiliated with any political action committees.';
			
			$this->bPic['aryeh'] = 'aryeh.png';
			$this->bName['aryeh'] = 'Aryeh Coburn-Soloway';
			$this->bInfo['aryeh'] = 'Br &rsquo;16, Writer';
			$this->bBio['aryeh'] = 'Aryeh Coburn-Soloway, better known as &ldquo;R-YAY!&rdquo; is an Economics major who spends most of his time searching for the meaning of life on Netflix and lifting weights in gyms at Payne Whitney and Branford. He&lsquo;s a member of the YCC Business Team, proud Steelers fan, and undercover romantic. If you happen to see him around campus just ignore the headphones and perpetually furrowed brow&ndash;tap him on the shoulder, ask to workout with him sometime, and prepare to have a smiley new friend!';
			
			$this->bPic['austin'] = 'austin.png';
			$this->bName['austin'] = 'Austin Johnson';
			$this->bInfo['austin'] = 'Pc &rsquo;16, Writer';
			$this->bBio['austin'] = 'Austin Johnson is a jaded sophomore History of Art major at Yale. When he&lsquo;s not trying to say contrived things about art for class and at casual dinner parties, he watches family guy and also travels around America with an a cappella group on campus. He loves his dog Bentley more than most humans and will do many questionable things for a cookies and cream milkshake.';
			
			$this->bPic['jenny'] = 'jenny.png';
			$this->bName['jenny'] = 'Jenny Park';
			$this->bInfo['jenny'] = 'Br &rsquo;16, Writer';
			$this->bBio['jenny'] = 'Jenny Park is a double major in MCDB and Art. She enjoys watching online tv shows, eating jalapeno-flavored chips, and finding pastel-colored clothing. Jenny aspires to go to medical school and likes to coordinate K-pop dances in her free time.';
			
			$this->bPic['stephany'] = 'stephany.png';
			$this->bName['stephany'] = 'Stephany Rhee';
			$this->bInfo['stephany'] = 'Sy &rsquo;16, Writer';
			$this->bBio['stephany'] = 'Stephany is a sophomore in Saybrook College majoring in EECS. She likes meeting people, exploring cities, scavengering for avant-garde fashion, and mastering cuisines!';
			
			$this->bPic['rebecca'] = 'rebecca.png';
			$this->bName['rebecca'] = 'Rebecca Su';
			$this->bInfo['rebecca'] = 'Sm &rsquo;16, Writer';
			$this->bBio['rebecca'] = 'Rebecca Su is a BME major, who also manages the Yale Scientific Magazine. In her spare time, Rebecca is active in Danceworks, and she will be working on a start-up this summer.';
			
			$this->bPic['karin'] = 'karin.png';
			$this->bName['karin'] = 'Karin Shedd';
			$this->bInfo['karin'] = 'Bk &rsquo;16, Writer';
			$this->bBio['karin'] = 'Karin Shedd is a Psych major and Master&rsquo;s Aide who, like many of her contemporaries, spends more time than is healthy perusing the internet in an effort to avoid more important things, like exercise, class, and potentially-awkward social interactions. If anyone has any experience in motivating severely-unmotivatable people to stop watching Game of Thrones on repeat and step away from their futons, please contact Karin Shedd. Please. It&rsquo;s been three days and no one&rsquo;s heard anything from her. This is a concerned friend typing. We suspect she&rsquo;s still under the pile of pillows on the futon, but we can&rsquo;t be sure and, frankly, we&rsquo;re a little scared to check. Send help.';
			
			$this->bPic['brea'] = 'brea.png';
			$this->bName['brea'] = 'Brea Baker';
			$this->bInfo['brea'] = 'Sy &rsquo;16, Writer';
			$this->bBio['brea'] = 'Brea Baker spends most of her time obsessing over Beyonc&eacute;, eating sushi or Popeyes, reading natural hair blogs and watching Scandal. She is a Political Science major in Say-What?! Saybrook! Her passions include community service, travelling, and human rights advocacy.';
		}
		
		public function addBio($name) {
			if (!isset($this->bPic[$name])) {
				foreach ($this->bName as $short => $n) {
					if ($name == $n) {
						$name = $short;
						break;
					}
				}
			}
			if (isset($this->bPic[$name])) {
				echo (string)'<div class="pic" style="background-image: url(' . $this->headerfolder.$this->bPic[$name] . ');"></div>
				<div class="basicinfo"><b>' . $this->bName[$name] . '</b><br />' .
				$this->bInfo[$name] . '<br /><br />
				</div><br />
				<div class="text">' . $this->bBio[$name] . '</div><br /><br />';
			}
		}
	}
	$Bios = new Bios($headerfolder);
?>