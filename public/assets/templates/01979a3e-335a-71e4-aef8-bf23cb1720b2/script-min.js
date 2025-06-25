let isMusicPlaying=!1;let currentSection='hero';let scrollAnimationId=null;function ease(t,b,c,d){t/=d/2;if(t<1)return c/2*t*t+b;t--;return-c/2*(t*(t-2)-1)+b};function toggleAutoScroll(){const scrollBtn=document.getElementById('scrollBtn');if(scrollAnimationId){cancelAnimationFrame(scrollAnimationId);scrollAnimationId=null;scrollBtn.classList.remove('scrolling')}else{const scrollIcon=scrollBtn.querySelector('i');const isScrollingDown=scrollIcon.classList.contains('fa-arrow-down');const targetPosition=isScrollingDown?document.body.scrollHeight-window.innerHeight:0;animateScroll(targetPosition)}}
function animateScroll(targetPosition){const scrollBtn=document.getElementById('scrollBtn');const scrollIcon=scrollBtn.querySelector('i');scrollBtn.classList.add('scrolling');const duration=30000;const start=window.pageYOffset;const distance=targetPosition-start;let startTime=null;function animation(currentTime){if(startTime===null)startTime=currentTime;const timeElapsed=currentTime-startTime;const run=ease(timeElapsed,start,distance,duration);window.scrollTo(0,run);if(timeElapsed<duration){scrollAnimationId=requestAnimationFrame(animation)}else{scrollAnimationId=null;scrollBtn.classList.remove('scrolling');if(targetPosition>0){scrollIcon.className='fas fa-arrow-up'}else{scrollIcon.className='fas fa-arrow-down'}}}
scrollAnimationId=requestAnimationFrame(animation)}
function openInvitation(){const coverPage=document.getElementById('coverPage');const mainContent=document.getElementById('mainContent');coverPage.classList.add('hidden');setTimeout(()=>{mainContent.classList.add('show');playMusic();showSection('hero')},1000)}
function playMusic(){const music=document.getElementById('bgMusic');const musicBtn=document.getElementById('musicBtn');const musicIcon=document.getElementById('musicIcon');music.play().then(()=>{isMusicPlaying=!0;musicIcon.className='fas fa-pause'}).catch(error=>{console.log('Music autoplay blocked:',error)})}
function toggleMusic(){const music=document.getElementById('bgMusic');const musicIcon=document.getElementById('musicIcon');if(isMusicPlaying){music.pause();musicIcon.className='fas fa-play';isMusicPlaying=!1}else{music.play();musicIcon.className='fas fa-pause';isMusicPlaying=!0}}
function scrollToSection(sectionId){const section=document.getElementById(sectionId);const menuItems=document.querySelectorAll('.menu-item');menuItems.forEach(item=>item.classList.remove('active'));event.currentTarget.classList.add('active');section.scrollIntoView({behavior:'smooth'});currentSection=sectionId}
function showSection(sectionId){const section=document.getElementById(sectionId);section.classList.add('visible')}
const observerOptions={threshold:0.1,rootMargin:'0px 0px -50px 0px'};const observer=new IntersectionObserver((entries)=>{entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('visible')}})},observerOptions);document.addEventListener('DOMContentLoaded',()=>{const sections=document.querySelectorAll('.section');sections.forEach(section=>{observer.observe(section)});displayMessages()});function submitGuestBook(){const name=document.getElementById('guestName').value.trim();const message=document.getElementById('guestMessage').value.trim();const attendance=document.getElementById('attendanceSelect').value;if(!name||!message){alert('Mohon isi nama dan ucapan Anda');return}
const newMessage={id:Date.now(),name:name,message:message,attendance:attendance,date:new Date().toLocaleString('id-ID',{year:'numeric',month:'long',day:'numeric',hour:'2-digit',minute:'2-digit'}),replies:[]};let messages=JSON.parse(localStorage.getItem('guestMessages')||'[]');messages.unshift(newMessage);localStorage.setItem('guestMessages',JSON.stringify(messages));displayMessages();alert('Terima kasih atas ucapan dan doa Anda!');document.getElementById('guestName').value='';document.getElementById('guestMessage').value='';document.getElementById('attendanceSelect').value=''}
function escapeHtml(text){const div=document.createElement('div');div.textContent=text;return div.innerHTML}
function displayMessages(){const messagesContainer=document.getElementById('messagesContainer');const messageCount=document.getElementById('messageCount');const messages=JSON.parse(localStorage.getItem('guestMessages')||'[]');if(messages.length===0){messageCount.textContent='Belum ada ucapan';messagesContainer.innerHTML='<div class="no-messages">Belum ada ucapan dari tamu. Jadilah yang pertama mengirim ucapan!</div>';return}
messageCount.textContent=`${messages.length} ucapan dari tamu`;messagesContainer.innerHTML='';messages.forEach(msg=>{const messageCard=document.createElement('div');messageCard.className='message-card';const initials=msg.name.split(' ').map(n=>n[0]).join('').toUpperCase().slice(0,2);let nameHTML=escapeHtml(msg.name);if(msg.attendance){let iconClass='';let iconColorClass='';if(msg.attendance==='Hadir'){iconClass='fa-check-circle';iconColorClass='attending-icon'}else if(msg.attendance==='Tidak Hadir'){iconClass='fa-times-circle';iconColorClass='not-attending-icon'}else if(msg.attendance==='Masih Ragu'){iconClass='fa-question-circle';iconColorClass='maybe-attending-icon'}
if(iconClass){nameHTML+=` <i class="fas ${iconClass} ${iconColorClass}" title="Kehadiran: ${msg.attendance}"></i>`}}
messageCard.innerHTML=`
            <div class="message-header">
                <div class="message-avatar">${initials}</div>
                <div class="message-info">
                    <div class="message-name">${nameHTML}</div>
                    <div class="message-date">${msg.date}</div>
                </div>
            </div>
            <div class="message-content">${escapeHtml(msg.message)}</div>
            <div class="message-actions">
                <button class="reply-btn" onclick="toggleReplyForm(${msg.id})">
                    <i class="fas fa-reply"></i> Balas
                </button>
            </div>
            <div class="reply-form" id="replyForm${msg.id}">
                <input type="text" class="reply-input" id="replyInput${msg.id}" placeholder="Tulis balasan...">
                <button class="reply-submit" onclick="submitReply(${msg.id})">Kirim Balasan</button>
            </div>
            ${msg.replies && msg.replies.length > 0 ? `<div class="replies">${msg.replies.map(reply=>`
                        <div class="reply-item">
                            <div class="reply-avatar">${reply.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)}</div>
                            <div class="reply-content">
                                <div class="reply-name">${escapeHtml(reply.name)}</div>
                                <div class="reply-text">${escapeHtml(reply.message)}</div>
                            </div>
                        </div>
                    `).join('')}</div>` : ''}
        `;messagesContainer.appendChild(messageCard)})}
function toggleReplyForm(messageId){const replyForm=document.getElementById(`replyForm${messageId}`);replyForm.classList.toggle('show')}
function submitReply(messageId){const replyInput=document.getElementById(`replyInput${messageId}`);const replyText=replyInput.value.trim();if(!replyText){alert('Mohon isi balasan Anda');return}
let messages=JSON.parse(localStorage.getItem('guestMessages')||'[]');const messageIndex=messages.findIndex(msg=>msg.id===messageId);if(messageIndex!==-1){if(!messages[messageIndex].replies){messages[messageIndex].replies=[]}
messages[messageIndex].replies.push({name:'Admin',message:replyText,date:new Date().toLocaleString('id-ID')});localStorage.setItem('guestMessages',JSON.stringify(messages));displayMessages();replyInput.value='';document.getElementById(`replyForm${messageId}`).classList.remove('show')}}
function openGalleryModal(imageSrc){const modal=document.getElementById('galleryModal');const modalImage=document.getElementById('modalImage');modalImage.src=imageSrc;modal.classList.add('show');document.body.style.overflow='hidden'}
function closeGalleryModal(){const modal=document.getElementById('galleryModal');modal.classList.remove('show');document.body.style.overflow='auto'}
document.addEventListener('click',function(event){const modal=document.getElementById('galleryModal');if(event.target===modal){closeGalleryModal()}});document.addEventListener('keydown',function(event){if(event.key==='Escape'){closeGalleryModal()}});function copyToClipboard(elementId,event){let text;if(elementId==='address'){text='Jl. Sudirman No. 123, Jakarta Selatan'}else{const element=document.getElementById(elementId);text=element.textContent}
navigator.clipboard.writeText(text).then(()=>{const btn=event.target;const originalText=btn.innerHTML;btn.innerHTML='<i class="fas fa-check"></i> Tersalin!';btn.style.background='#28a745';setTimeout(()=>{btn.innerHTML=originalText;btn.style.background='#667eea'},2000)}).catch(err=>{console.error('Failed to copy: ',err);const textArea=document.createElement('textarea');textArea.value=text;document.body.appendChild(textArea);textArea.select();try{document.execCommand('copy');alert('Nomor rekening berhasil disalin!')}catch(err){alert('Gagal menyalin nomor rekening. Silakan salin manual: '+text)}
document.body.removeChild(textArea)})}
function openMaps(location){const url=`https://www.google.com/maps/search/${encodeURIComponent(location)}`;window.open(url,'_blank')}
window.addEventListener('scroll',()=>{const sections=document.querySelectorAll('.section');const menuItems=document.querySelectorAll('.menu-item');let current='';sections.forEach(section=>{const sectionTop=section.offsetTop;const sectionHeight=section.clientHeight;if(pageYOffset>=(sectionTop-200)){current=section.getAttribute('id')}});menuItems.forEach(item=>{item.classList.remove('active');if(item.getAttribute('onclick').includes(current)){item.classList.add('active')}})});document.addEventListener('contextmenu',e=>e.preventDefault());document.addEventListener('selectstart',e=>e.preventDefault());function updateCountdown(){const weddingDate=new Date('May 7, 2027 08:00:00').getTime();const now=new Date().getTime();const distance=weddingDate-now;if(distance>0){const days=Math.floor(distance/(1000*60*60*24));const hours=Math.floor((distance%(1000*60*60*24))/(1000*60*60));const minutes=Math.floor((distance%(1000*60*60))/(1000*60));const seconds=Math.floor((distance%(1000*60))/1000);document.getElementById('days').textContent=days.toString().padStart(2,'0');document.getElementById('hours').textContent=hours.toString().padStart(2,'0');document.getElementById('minutes').textContent=minutes.toString().padStart(2,'0');document.getElementById('seconds').textContent=seconds.toString().padStart(2,'0')}else{document.getElementById('days').textContent='00';document.getElementById('hours').textContent='00';document.getElementById('minutes').textContent='00';document.getElementById('seconds').textContent='00'}}
setInterval(updateCountdown,1000);updateCountdown();function saveToCalendar(eventType){let eventData;if(eventType==='akad'){eventData={title:'Akad Nikah - Ahmad & Siti',start:'2027-05-07T08:00:00',end:'2027-05-07T10:00:00',location:'Masjid Al-Hikmah, Jl. Sudirman No. 123, Jakarta',description:'Akad Nikah Ahmad Fadillah & Siti Nurhaliza\n\nMasjid Al-Hikmah\nJl. Sudirman No. 123, Jakarta\n\nDress Code: Muslim Formal'}}else if(eventType==='resepsi'){eventData={title:'Resepsi Pernikahan - Ahmad & Siti',start:'2027-05-07T11:00:00',end:'2027-05-07T14:00:00',location:'Hotel Grand Palace, Jl. Thamrin No. 456, Jakarta',description:'Resepsi Pernikahan Ahmad Fadillah & Siti Nurhaliza\n\nHotel Grand Palace\nJl. Thamrin No. 456, Jakarta\n\nDress Code: Formal'}}
const startDate=new Date(eventData.start);const endDate=new Date(eventData.end);const formatDate=(date)=>{return date.toISOString().replace(/[-:]/g,'').replace(/\.\d{3}/,'')};const googleUrl=`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventData.title)}&dates=${formatDate(startDate)}/${formatDate(endDate)}&details=${encodeURIComponent(eventData.description)}&location=${encodeURIComponent(eventData.location)}`;const outlookUrl=`https://outlook.live.com/calendar/0/deeplink/compose?subject=${encodeURIComponent(eventData.title)}&startdt=${startDate.toISOString()}&enddt=${endDate.toISOString()}&body=${encodeURIComponent(eventData.description)}&location=${encodeURIComponent(eventData.location)}`;const calendarOptions=[{name:'Google Calendar',url:googleUrl,icon:'fab fa-google'},{name:'Outlook Calendar',url:outlookUrl,icon:'fas fa-envelope'}];showCalendarOptions(calendarOptions,eventData.title)}
function showCalendarOptions(options,eventTitle){const modal=document.createElement('div');modal.style.cssText=`
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2000;
        backdrop-filter: blur(5px);
    `;const modalContent=document.createElement('div');modalContent.style.cssText=`
        background: white;
        padding: 2rem;
        border-radius: 20px;
        max-width: 90vw;
        width: 400px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    `;modalContent.innerHTML=`
        <h3 style="margin-bottom: 1.5rem; color: #333; font-size: 1.2rem;">Pilih Kalender untuk "${eventTitle}"</h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            ${options.map(option => `<button onclick="openCalendar('${option.url}')" style="
                    background: linear-gradient(45deg, #667eea, #764ba2);
                    color: white;
                    border: none;
                    padding: 1rem;
                    border-radius: 15px;
                    cursor: pointer;
                    font-size: 1rem;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 0.5rem;
                " onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'"><i class="${option.icon}"></i>${option.name}</button>`).join('')}
        </div>
        <button onclick="closeCalendarModal()" style="
            background: #f8f9fa;
            color: #666;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 15px;
            cursor: pointer;
            margin-top: 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        " onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#f8f9fa'">
            Batal
        </button>
    `;modal.appendChild(modalContent);document.body.appendChild(modal);modal.addEventListener('click',(e)=>{if(e.target===modal){closeCalendarModal()}})}
function openCalendar(url){window.open(url,'_blank');closeCalendarModal()}
function closeCalendarModal(){const modal=document.querySelector('div[style*="z-index: 2000"]');if(modal){modal.remove()}}