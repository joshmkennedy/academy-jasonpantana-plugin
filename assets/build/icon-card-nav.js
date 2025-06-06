(()=>{"use strict";function n(n){return"number"==typeof n}function t(n){return"string"==typeof n}function e(n){return"boolean"==typeof n}function r(n){return"[object Object]"===Object.prototype.toString.call(n)}function o(n){return Math.abs(n)}function i(n){return Math.sign(n)}function c(n,t){return o(n-t)}function s(n){return f(n).map(Number)}function u(n){return n[a(n)]}function a(n){return Math.max(0,n.length-1)}function l(n,t){return t===a(n)}function d(n,t=0){return Array.from(Array(n),((n,e)=>t+e))}function f(n){return Object.keys(n)}function p(n,t){return[n,t].reduce(((n,t)=>(f(t).forEach((e=>{const o=n[e],i=t[e],c=r(o)&&r(i);n[e]=c?p(o,i):i})),n)),{})}function m(n,t){return void 0!==t.MouseEvent&&n instanceof t.MouseEvent}function g(){let n=[];const t={add:function(e,r,o,i={passive:!0}){let c;if("addEventListener"in e)e.addEventListener(r,o,i),c=()=>e.removeEventListener(r,o,i);else{const n=e;n.addListener(o),c=()=>n.removeListener(o)}return n.push(c),t},clear:function(){n=n.filter((n=>n()))}};return t}function h(n=0,t=0){const e=o(n-t);function r(t){return t<n}function i(n){return n>t}function c(n){return r(n)||i(n)}return{length:e,max:t,min:n,constrain:function(e){return c(e)?r(e)?n:t:e},reachedAny:c,reachedMax:i,reachedMin:r,removeOffset:function(n){return e?n-e*Math.ceil((n-t)/e):n}}}function v(n,t,e){const{constrain:r}=h(0,n),i=n+1;let c=s(t);function s(n){return e?o((i+n)%i):r(n)}function u(){return c}function a(){return v(n,u(),e)}const l={get:u,set:function(n){return c=s(n),l},add:function(n){return a().set(u()+n)},clone:a};return l}function b(n,t,r,s,u,a,l,d,f,p,v,b,x,y,S,L,w,E,A){const{cross:D,direction:I}=n,M=["INPUT","SELECT","TEXTAREA"],T={passive:!1},F=g(),O=g(),P=h(50,225).constrain(y.measure(20)),k={mouse:300,touch:400},H={mouse:500,touch:600},_=S?43:25;let z=!1,V=0,q=0,B=!1,N=!1,C=!1,R=!1;function j(n){if(!m(n,s)&&n.touches.length>=2)return G(n);const t=a.readPoint(n),e=a.readPoint(n,D),r=c(t,V),o=c(e,q);if(!N&&!R){if(!n.cancelable)return G(n);if(N=r>o,!N)return G(n)}const i=a.pointerMove(n);r>L&&(C=!0),p.useFriction(.3).useDuration(.75),d.start(),u.add(I(i)),n.preventDefault()}function G(n){const t=v.byDistance(0,!1).index!==b.get(),e=a.pointerUp(n)*(S?H:k)[R?"mouse":"touch"],r=function(n,t){const e=b.add(-1*i(n)),r=v.byDistance(n,!S).distance;return S||o(n)<P?r:w&&t?.5*r:v.byIndex(e.get(),0).distance}(I(e),t),s=function(n,t){if(0===n||0===t)return 0;if(o(n)<=o(t))return 0;const e=c(o(n),o(t));return o(e/n)}(e,r),u=_-10*s,l=E+s/50;N=!1,B=!1,O.clear(),p.useDuration(u).useFriction(l),f.distance(r,!S),R=!1,x.emit("pointerUp")}function U(n){C&&(n.stopPropagation(),n.preventDefault(),C=!1)}return{init:function(n){if(!A)return;function o(o){(e(A)||A(n,o))&&function(n){const e=m(n,s);R=e,C=S&&e&&!n.buttons&&z,z=c(u.get(),l.get())>=2,e&&0!==n.button||function(n){const t=n.nodeName||"";return M.includes(t)}(n.target)||(B=!0,a.pointerDown(n),p.useFriction(0).useDuration(0),u.set(l),function(){const n=R?r:t;O.add(n,"touchmove",j,T).add(n,"touchend",G).add(n,"mousemove",j,T).add(n,"mouseup",G)}(),V=a.readPoint(n),q=a.readPoint(n,D),x.emit("pointerDown"))}(o)}const i=t;F.add(i,"dragstart",(n=>n.preventDefault()),T).add(i,"touchmove",(()=>{}),T).add(i,"touchend",(()=>{})).add(i,"touchstart",o).add(i,"mousedown",o).add(i,"touchcancel",G).add(i,"contextmenu",G).add(i,"click",U,!0)},destroy:function(){F.clear(),O.clear()},pointerDown:function(){return B}}}function x(n,t){let e,r;function i(n){return n.timeStamp}function c(e,r){const o="client"+("x"===(r||n.scroll)?"X":"Y");return(m(e,t)?e:e.touches[0])[o]}return{pointerDown:function(n){return e=n,r=n,c(n)},pointerMove:function(n){const t=c(n)-c(r),o=i(n)-i(e)>170;return r=n,o&&(e=n),t},pointerUp:function(n){if(!e||!r)return 0;const t=c(r)-c(e),s=i(n)-i(e),u=i(n)-i(r)>170,a=t/s;return s&&!u&&o(a)>.1?a:0},readPoint:c}}function y(n,t,r,i,c,s,u){const a=[n].concat(i);let l,d,f=[],p=!1;function m(n){return c.measureSize(u.measure(n))}return{init:function(c){s&&(d=m(n),f=i.map(m),l=new ResizeObserver((r=>{(e(s)||s(c,r))&&function(e){for(const r of e){if(p)return;const e=r.target===n,s=i.indexOf(r.target),u=e?d:f[s];if(o(m(e?n:i[s])-u)>=.5){c.reInit(),t.emit("resize");break}}}(r)})),r.requestAnimationFrame((()=>{a.forEach((n=>l.observe(n)))})))},destroy:function(){p=!0,l&&l.disconnect()}}}function S(n,t,e,r,i){const c=i.measure(10),s=i.measure(50),u=h(.1,.99);let a=!1;function l(){return!a&&!!n.reachedAny(e.get())&&!!n.reachedAny(t.get())}return{shouldConstrain:l,constrain:function(i){if(!l())return;const a=n.reachedMin(t.get())?"min":"max",d=o(n[a]-t.get()),f=e.get()-t.get(),p=u.constrain(d/s);e.subtract(f*p),!i&&o(f)<c&&(e.set(n.constrain(e.get())),r.useDuration(25).useBaseFriction())},toggleActive:function(n){a=!n}}}function L(n,t,e,r){const o=t.min+.1,i=t.max+.1,{reachedMin:c,reachedMax:s}=h(o,i);return{loop:function(t){if(!function(n){return 1===n?s(e.get()):-1===n&&c(e.get())}(t))return;const o=n*(-1*t);r.forEach((n=>n.add(o)))}}}function w(t){let e=t;function r(t){return n(t)?t:t.get()}return{get:function(){return e},set:function(n){e=r(n)},add:function(n){e+=r(n)},subtract:function(n){e-=r(n)}}}function E(n,t){const e="x"===n.scroll?function(n){return`translate3d(${n}px,0px,0px)`}:function(n){return`translate3d(0px,${n}px,0px)`},r=t.style;let o=null,i=!1;return{clear:function(){i||(r.transform="",t.getAttribute("style")||t.removeAttribute("style"))},to:function(t){if(i)return;const c=(s=n.direction(t),Math.round(100*s)/100);var s;c!==o&&(r.transform=e(c),o=c)},toggleActive:function(n){i=!n}}}function A(n,t,e,r,o,i,c,u,a){const l=s(o),d=s(o).reverse(),f=function(){const n=c[0];return g(m(d,n),e,!1)}().concat(function(){const n=t-c[0]-1;return g(m(l,n),-e,!0)}());function p(n,t){return n.reduce(((n,t)=>n-o[t]),t)}function m(n,t){return n.reduce(((n,e)=>p(n,t)>0?n.concat([e]):n),[])}function g(o,c,s){const l=function(n){return i.map(((e,o)=>({start:e-r[o]+.5+n,end:e+t-.5+n})))}(c);return o.map((t=>{const r=s?0:-e,o=s?e:0,i=s?"end":"start",c=l[t][i];return{index:t,loopPoint:c,slideLocation:w(-1),translate:E(n,a[t]),target:()=>u.get()>c?r:o}}))}return{canLoop:function(){return f.every((({index:n})=>p(l.filter((t=>t!==n)),t)<=.1))},clear:function(){f.forEach((n=>n.translate.clear()))},loop:function(){f.forEach((n=>{const{target:t,translate:e,slideLocation:r}=n,o=t();o!==r.get()&&(e.to(o),r.set(o))}))},loopPoints:f}}function D(n,t,r){let o,i=!1;return{init:function(c){r&&(o=new MutationObserver((n=>{i||(e(r)||r(c,n))&&function(n){for(const e of n)if("childList"===e.type){c.reInit(),t.emit("slidesChanged");break}}(n)})),o.observe(n,{childList:!0}))},destroy:function(){o&&o.disconnect(),i=!0}}}function I(r,p,m,I,M,T,F){const{align:O,axis:P,direction:k,startIndex:H,loop:_,duration:z,dragFree:V,dragThreshold:q,inViewThreshold:B,slidesToScroll:N,skipSnaps:C,containScroll:R,watchResize:j,watchSlides:G,watchDrag:U,watchFocus:W}=T,$={measure:function(n){const{offsetTop:t,offsetLeft:e,offsetWidth:r,offsetHeight:o}=n;return{top:t,right:e+r,bottom:t+o,left:e,width:r,height:o}}},Q=$.measure(p),X=m.map($.measure),Y=function(n,t){const e="rtl"===t,r="y"===n,o=!r&&e?-1:1;return{scroll:r?"y":"x",cross:r?"x":"y",startEdge:r?"top":e?"right":"left",endEdge:r?"bottom":e?"left":"right",measureSize:function(n){const{height:t,width:e}=n;return r?t:e},direction:function(n){return n*o}}}(P,k),J=Y.measureSize(Q),K=function(n){return{measure:function(t){return n*(t/100)}}}(J),Z=function(n,e){const r={start:function(){return 0},center:function(n){return o(n)/2},end:o};function o(n){return e-n}return{measure:function(o,i){return t(n)?r[n](o):n(e,o,i)}}}(O,J),nn=!_&&!!R,tn=_||!!R,{slideSizes:en,slideSizesWithGaps:rn,startGap:on,endGap:cn}=function(n,t,e,r,i,c){const{measureSize:s,startEdge:a,endEdge:d}=n,f=e[0]&&i,p=function(){if(!f)return 0;const n=e[0];return o(t[a]-n[a])}(),m=function(){if(!f)return 0;const n=c.getComputedStyle(u(r));return parseFloat(n.getPropertyValue(`margin-${d}`))}(),g=e.map(s),h=e.map(((n,t,e)=>{const r=!t,o=l(e,t);return r?g[t]+p:o?g[t]+m:e[t+1][a]-n[a]})).map(o);return{slideSizes:g,slideSizesWithGaps:h,startGap:p,endGap:m}}(Y,Q,X,m,tn,M),sn=function(t,e,r,i,c,l,d,f,p){const{startEdge:m,endEdge:g,direction:h}=t,v=n(r);return{groupSlides:function(n){return v?function(n,t){return s(n).filter((n=>n%t==0)).map((e=>n.slice(e,e+t)))}(n,r):function(n){return n.length?s(n).reduce(((t,r,s)=>{const v=u(t)||0,b=0===v,x=r===a(n),y=c[m]-l[v][m],S=c[m]-l[r][g],L=!i&&b?h(d):0,w=o(S-(!i&&x?h(f):0)-(y+L));return s&&w>e+p&&t.push(r),x&&t.push(n.length),t}),[]).map(((t,e,r)=>{const o=Math.max(r[e-1]||0);return n.slice(o,t)})):[]}(n)}}}(Y,J,N,_,Q,X,on,cn,2),{snaps:un,snapsAligned:an}=function(n,t,e,r,i){const{startEdge:c,endEdge:s}=n,{groupSlides:a}=i,l=a(r).map((n=>u(n)[s]-n[0][c])).map(o).map(t.measure),d=r.map((n=>e[c]-n[c])).map((n=>-o(n))),f=a(d).map((n=>n[0])).map(((n,t)=>n+l[t]));return{snaps:d,snapsAligned:f}}(Y,Z,Q,X,sn),ln=-u(un)+u(rn),{snapsContained:dn,scrollContainLimit:fn}=function(n,t,e,r){const o=h(-t+n,0),i=e.map(((n,t)=>{const{min:r,max:i}=o,c=o.constrain(n),s=!t,u=l(e,t);return s?i:u||a(r,c)?r:a(i,c)?i:c})).map((n=>parseFloat(n.toFixed(3)))),s=function(){const n=i[0],t=u(i);return h(i.lastIndexOf(n),i.indexOf(t)+1)}();function a(n,t){return c(n,t)<=1}return{snapsContained:function(){if(t<=n+2)return[o.max];if("keepSnaps"===r)return i;const{min:e,max:c}=s;return i.slice(e,c)}(),scrollContainLimit:s}}(J,ln,an,R),pn=nn?dn:an,{limit:mn}=function(n,t,e){const r=t[0];return{limit:h(e?r-n:u(t),r)}}(ln,pn,_),gn=v(a(pn),H,_),hn=gn.clone(),vn=s(m),bn=function(n,t,e,r){const o=g(),i=1e3/60;let c=null,s=0,u=0;function a(n){if(!u)return;c||(c=n,e(),e());const o=n-c;for(c=n,s+=o;s>=i;)e(),s-=i;r(s/i),u&&(u=t.requestAnimationFrame(a))}function l(){t.cancelAnimationFrame(u),c=null,s=0,u=0}return{init:function(){o.add(n,"visibilitychange",(()=>{n.hidden&&(c=null,s=0)}))},destroy:function(){l(),o.clear()},start:function(){u||(u=t.requestAnimationFrame(a))},stop:l,update:e,render:r}}(I,M,(()=>(({dragHandler:n,scrollBody:t,scrollBounds:e,options:{loop:r}})=>{r||e.constrain(n.pointerDown()),t.seek()})(Pn)),(n=>(({scrollBody:n,translate:t,location:e,offsetLocation:r,previousLocation:o,scrollLooper:i,slideLooper:c,dragHandler:s,animation:u,eventHandler:a,scrollBounds:l,options:{loop:d}},f)=>{const p=n.settled(),m=!l.shouldConstrain(),g=d?p:p&&m;g&&!s.pointerDown()&&(u.stop(),a.emit("settle")),g||a.emit("scroll");const h=e.get()*f+o.get()*(1-f);r.set(h),d&&(i.loop(n.direction()),c.loop()),t.to(r.get())})(Pn,n))),xn=pn[gn.get()],yn=w(xn),Sn=w(xn),Ln=w(xn),wn=w(xn),En=function(n,t,e,r,c){let s=0,u=0,a=c,l=.68,d=n.get(),f=0;function p(n){return a=n,g}function m(n){return l=n,g}const g={direction:function(){return u},duration:function(){return a},velocity:function(){return s},seek:function(){const t=r.get()-n.get();let o=0;return a?(e.set(n),s+=t/a,s*=l,d+=s,n.add(s),o=d-f):(s=0,e.set(r),n.set(r),o=t),u=i(o),f=d,g},settled:function(){return o(r.get()-t.get())<.001},useBaseFriction:function(){return m(.68)},useBaseDuration:function(){return p(c)},useFriction:m,useDuration:p};return g}(yn,Ln,Sn,wn,z),An=function(n,t,e,r,c){const{reachedAny:s,removeOffset:a,constrain:l}=r;function d(n){return n.concat().sort(((n,t)=>o(n)-o(t)))[0]}function f(t,r){const o=[t,t+e,t-e];if(!n)return t;if(!r)return d(o);const c=o.filter((n=>i(n)===r));return c.length?d(c):u(o)-e}return{byDistance:function(e,r){const i=c.get()+e,{index:u,distance:d}=function(e){const r=n?a(e):l(e),i=t.map(((n,t)=>({diff:f(n-r,0),index:t}))).sort(((n,t)=>o(n.diff)-o(t.diff))),{index:c}=i[0];return{index:c,distance:r}}(i),p=!n&&s(i);return!r||p?{index:u,distance:e}:{index:u,distance:e+f(t[u]-d,0)}},byIndex:function(n,e){return{index:n,distance:f(t[n]-c.get(),e)}},shortcut:f}}(_,pn,ln,mn,wn),Dn=function(n,t,e,r,o,i,c){function s(o){const s=o.distance,u=o.index!==t.get();i.add(s),s&&(r.duration()?n.start():(n.update(),n.render(1),n.update())),u&&(e.set(t.get()),t.set(o.index),c.emit("select"))}return{distance:function(n,t){s(o.byDistance(n,t))},index:function(n,e){const r=t.clone().set(n);s(o.byIndex(r.get(),e))}}}(bn,gn,hn,En,An,wn,F),In=function(n){const{max:t,length:e}=n;return{get:function(n){return e?(n-t)/-e:0}}}(mn),Mn=g(),Tn=function(n,t,e,r){const o={};let i,c=null,s=null,u=!1;return{init:function(){i=new IntersectionObserver((n=>{u||(n.forEach((n=>{const e=t.indexOf(n.target);o[e]=n})),c=null,s=null,e.emit("slidesInView"))}),{root:n.parentElement,threshold:r}),t.forEach((n=>i.observe(n)))},destroy:function(){i&&i.disconnect(),u=!0},get:function(n=!0){if(n&&c)return c;if(!n&&s)return s;const t=function(n){return f(o).reduce(((t,e)=>{const r=parseInt(e),{isIntersecting:i}=o[r];return(n&&i||!n&&!i)&&t.push(r),t}),[])}(n);return n&&(c=t),n||(s=t),t}}}(p,m,F,B),{slideRegistry:Fn}=function(n,t,e,r,o,i){const{groupSlides:c}=o,{min:s,max:f}=r;return{slideRegistry:function(){const r=c(i),o=!n||"keepSnaps"===t;return 1===e.length?[i]:o?r:r.slice(s,f).map(((n,t,e)=>{const r=!t,o=l(e,t);return r?d(u(e[0])+1):o?d(a(i)-u(e)[0]+1,u(e)[0]):n}))}()}}(nn,R,pn,fn,sn,vn),On=function(t,r,o,i,c,s,u,a){const l={passive:!0,capture:!0};let d=0;function f(n){"Tab"===n.code&&(d=(new Date).getTime())}return{init:function(p){a&&(s.add(document,"keydown",f,!1),r.forEach(((r,f)=>{s.add(r,"focus",(r=>{(e(a)||a(p,r))&&function(e){if((new Date).getTime()-d>10)return;u.emit("slideFocusStart"),t.scrollLeft=0;const r=o.findIndex((n=>n.includes(e)));n(r)&&(c.useDuration(0),i.index(r,0),u.emit("slideFocus"))}(f)}),l)})))}}}(r,m,Fn,Dn,En,Mn,F,W),Pn={ownerDocument:I,ownerWindow:M,eventHandler:F,containerRect:Q,slideRects:X,animation:bn,axis:Y,dragHandler:b(Y,r,I,M,wn,x(Y,M),yn,bn,Dn,En,An,gn,F,K,V,q,C,.68,U),eventStore:Mn,percentOfView:K,index:gn,indexPrevious:hn,limit:mn,location:yn,offsetLocation:Ln,previousLocation:Sn,options:T,resizeHandler:y(p,F,M,m,Y,j,$),scrollBody:En,scrollBounds:S(mn,Ln,wn,En,K),scrollLooper:L(ln,mn,Ln,[yn,Ln,Sn,wn]),scrollProgress:In,scrollSnapList:pn.map(In.get),scrollSnaps:pn,scrollTarget:An,scrollTo:Dn,slideLooper:A(Y,J,ln,en,rn,un,pn,Ln,m),slideFocus:On,slidesHandler:D(p,F,G),slidesInView:Tn,slideIndexes:vn,slideRegistry:Fn,slidesToScroll:sn,target:wn,translate:E(Y,p)};return Pn}const M={align:"center",axis:"x",container:null,slides:null,containScroll:"trimSnaps",direction:"ltr",slidesToScroll:1,inViewThreshold:0,breakpoints:{},dragFree:!1,dragThreshold:10,loop:!1,skipSnaps:!1,duration:25,startIndex:0,active:!0,watchDrag:!0,watchResize:!0,watchSlides:!0,watchFocus:!0};function T(n){function t(n,t){return p(n,t||{})}return{mergeOptions:t,optionsAtMedia:function(e){const r=e.breakpoints||{},o=f(r).filter((t=>n.matchMedia(t).matches)).map((n=>r[n])).reduce(((n,e)=>t(n,e)),{});return t(e,o)},optionsMediaQueries:function(t){return t.map((n=>f(n.breakpoints||{}))).reduce(((n,t)=>n.concat(t)),[]).map(n.matchMedia)}}}function F(n,e,r){const o=n.ownerDocument,i=o.defaultView,c=T(i),s=function(n){let t=[];return{init:function(e,r){return t=r.filter((({options:t})=>!1!==n.optionsAtMedia(t).active)),t.forEach((t=>t.init(e,n))),r.reduce(((n,t)=>Object.assign(n,{[t.name]:t})),{})},destroy:function(){t=t.filter((n=>n.destroy()))}}}(c),u=g(),a=function(){let n,t={};function e(n){return t[n]||[]}const r={init:function(t){n=t},emit:function(t){return e(t).forEach((e=>e(n,t))),r},off:function(n,o){return t[n]=e(n).filter((n=>n!==o)),r},on:function(n,o){return t[n]=e(n).concat([o]),r},clear:function(){t={}}};return r}(),{mergeOptions:l,optionsAtMedia:d,optionsMediaQueries:f}=c,{on:p,off:m,emit:h}=a,v=P;let b,x,y,S,L=!1,w=l(M,F.globalOptions),E=l(w),A=[];function D(t){const e=I(n,y,S,o,i,t,a);return t.loop&&!e.slideLooper.canLoop()?D(Object.assign({},t,{loop:!1})):e}function O(e,r){L||(w=l(w,e),E=d(w),A=r||A,function(){const{container:e,slides:r}=E,o=t(e)?n.querySelector(e):e;y=o||n.children[0];const i=t(r)?y.querySelectorAll(r):r;S=[].slice.call(i||y.children)}(),b=D(E),f([w,...A.map((({options:n})=>n))]).forEach((n=>u.add(n,"change",P))),E.active&&(b.translate.to(b.location.get()),b.animation.init(),b.slidesInView.init(),b.slideFocus.init(z),b.eventHandler.init(z),b.resizeHandler.init(z),b.slidesHandler.init(z),b.options.loop&&b.slideLooper.loop(),y.offsetParent&&S.length&&b.dragHandler.init(z),x=s.init(z,A)))}function P(n,t){const e=_();k(),O(l({startIndex:e},n),t),a.emit("reInit")}function k(){b.dragHandler.destroy(),b.eventStore.clear(),b.translate.clear(),b.slideLooper.clear(),b.resizeHandler.destroy(),b.slidesHandler.destroy(),b.slidesInView.destroy(),b.animation.destroy(),s.destroy(),u.clear()}function H(n,t,e){E.active&&!L&&(b.scrollBody.useBaseFriction().useDuration(!0===t?0:E.duration),b.scrollTo.index(n,e||0))}function _(){return b.index.get()}const z={canScrollNext:function(){return b.index.add(1).get()!==_()},canScrollPrev:function(){return b.index.add(-1).get()!==_()},containerNode:function(){return y},internalEngine:function(){return b},destroy:function(){L||(L=!0,u.clear(),k(),a.emit("destroy"),a.clear())},off:m,on:p,emit:h,plugins:function(){return x},previousScrollSnap:function(){return b.indexPrevious.get()},reInit:v,rootNode:function(){return n},scrollNext:function(n){H(b.index.add(1).get(),n,-1)},scrollPrev:function(n){H(b.index.add(-1).get(),n,1)},scrollProgress:function(){return b.scrollProgress.get(b.location.get())},scrollSnapList:function(){return b.scrollSnapList},scrollTo:H,selectedScrollSnap:_,slideNodes:function(){return S},slidesInView:function(){return b.slidesInView.get()},slidesNotInView:function(){return b.slidesInView.get(!1)}};return O(e,r),setTimeout((()=>a.emit("init")),0),z}F.globalOptions=void 0;const O={loop:!1};addEventListener("DOMContentLoaded",(()=>{document.querySelectorAll(".icon-card-nav").forEach((n=>{!function(n,t={}){t={...O,...t};const e=n.querySelector(".embla__viewport"),r=n.querySelector(".embla__button--prev"),o=n.querySelector(".embla__button--next"),i=n.querySelector(".embla__dots");if(!e)return void console.log("no viewport node");const c=F(e,t);if(r&&o){const n=((n,t,e)=>{const r=()=>{n.scrollPrev()},o=()=>{n.scrollNext()};t.addEventListener("click",r,!1),e.addEventListener("click",o,!1);const i=((n,t,e)=>{const r=()=>{n.canScrollPrev()?t.removeAttribute("disabled"):t.setAttribute("disabled","disabled"),n.canScrollNext()?e.removeAttribute("disabled"):e.setAttribute("disabled","disabled")};return n.on("select",r).on("init",r).on("reInit",r),()=>{t.removeAttribute("disabled"),e.removeAttribute("disabled")}})(n,t,e);return()=>{i(),t.removeEventListener("click",r,!1),e.removeEventListener("click",o,!1)}})(c,r,o);c.on("destroy",n)}if(i){const n=((n,t)=>{let e=[];const r=()=>{t.innerHTML=n.scrollSnapList().map((()=>'<button class="embla__dot" type="button"></button>')).join(""),e=Array.from(t.querySelectorAll(".embla__dot")),e.forEach(((t,e)=>{t.addEventListener("click",(()=>(t=>{n.scrollTo(t)})(e)),!1)}))},o=()=>{const t=n.previousScrollSnap(),r=n.selectedScrollSnap();e[t].classList.remove("embla__dot--selected"),e[r].classList.add("embla__dot--selected")};return n.on("init",r).on("reInit",r).on("init",o).on("reInit",o).on("select",o),()=>{t.innerHTML=""}})(c,i);c.on("destroy",n)}}(n,{slidesToScroll:3})}))}))})();