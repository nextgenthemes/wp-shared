(function(){const e=document.createElement("link").relList;if(e&&e.supports&&e.supports("modulepreload"))return;for(const r of document.querySelectorAll('link[rel="modulepreload"]'))o(r);new MutationObserver(r=>{for(const s of r)if(s.type==="childList")for(const i of s.addedNodes)i.tagName==="LINK"&&i.rel==="modulepreload"&&o(i)}).observe(document,{childList:!0,subtree:!0});function n(r){const s={};return r.integrity&&(s.integrity=r.integrity),r.referrerPolicy&&(s.referrerPolicy=r.referrerPolicy),r.crossOrigin==="use-credentials"?s.credentials="include":r.crossOrigin==="anonymous"?s.credentials="omit":s.credentials="same-origin",s}function o(r){if(r.ep)return;r.ep=!0;const s=n(r);fetch(r.href,s)}})();function a(){}function N(t){return t()}function v(){return Object.create(null)}function p(t){t.forEach(N)}function A(t){return typeof t=="function"}function j(t,e){return t!=t?e==e:t!==e||t&&typeof t=="object"||typeof t=="function"}function C(t){return Object.keys(t).length===0}function q(t,e,n){t.insertBefore(e,n||null)}function L(t){t.parentNode&&t.parentNode.removeChild(t)}function M(t){return document.createElement(t)}function B(t,e,n){n==null?t.removeAttribute(e):t.getAttribute(e)!==n&&t.setAttribute(e,n)}function F(t){return Array.from(t.childNodes)}let $;function h(t){$=t}const l=[],E=[];let d=[];const k=[],I=Promise.resolve();let m=!1;function K(){m||(m=!0,I.then(P))}function y(t){d.push(t)}const g=new Set;let u=0;function P(){if(u!==0)return;const t=$;do{try{for(;u<l.length;){const e=l[u];u++,h(e),z(e.$$)}}catch(e){throw l.length=0,u=0,e}for(h(null),l.length=0,u=0;E.length;)E.pop()();for(let e=0;e<d.length;e+=1){const n=d[e];g.has(n)||(g.add(n),n())}d.length=0}while(l.length);for(;k.length;)k.pop()();m=!1,g.clear(),h(t)}function z(t){if(t.fragment!==null){t.update(),p(t.before_update);const e=t.dirty;t.dirty=[-1],t.fragment&&t.fragment.p(t.ctx,e),t.after_update.forEach(y)}}function D(t){const e=[],n=[];d.forEach(o=>t.indexOf(o)===-1?e.push(o):n.push(o)),n.forEach(o=>o()),d=e}const G=new Set;function H(t,e){t&&t.i&&(G.delete(t),t.i(e))}function J(t,e,n,o){const{fragment:r,after_update:s}=t.$$;r&&r.m(e,n),o||y(()=>{const i=t.$$.on_mount.map(N).filter(A);t.$$.on_destroy?t.$$.on_destroy.push(...i):p(i),t.$$.on_mount=[]}),s.forEach(y)}function Q(t,e){const n=t.$$;n.fragment!==null&&(D(n.after_update),p(n.on_destroy),n.fragment&&n.fragment.d(e),n.on_destroy=n.fragment=null,n.ctx=[])}function R(t,e){t.$$.dirty[0]===-1&&(l.push(t),K(),t.$$.dirty.fill(0)),t.$$.dirty[e/31|0]|=1<<e%31}function T(t,e,n,o,r,s,i,S=[-1]){const _=$;h(t);const c=t.$$={fragment:null,ctx:[],props:s,update:a,not_equal:r,bound:v(),on_mount:[],on_destroy:[],on_disconnect:[],before_update:[],after_update:[],context:new Map(e.context||(_?_.$$.context:[])),callbacks:v(),dirty:S,skip_bound:!1,root:e.target||_.$$.root};i&&i(c.root);let b=!1;if(c.ctx=n?n(t,e.props||{},(f,x,...w)=>{const O=w.length?w[0]:x;return c.ctx&&r(c.ctx[f],c.ctx[f]=O)&&(!c.skip_bound&&c.bound[f]&&c.bound[f](O),b&&R(t,f)),x}):[],c.update(),b=!0,p(c.before_update),c.fragment=o?o(c.ctx):!1,e.target){if(e.hydrate){const f=F(e.target);c.fragment&&c.fragment.l(f),f.forEach(L)}else c.fragment&&c.fragment.c();e.intro&&H(t.$$.fragment),J(t,e.target,e.anchor,e.customElement),P()}h(_)}class U{$destroy(){Q(this,1),this.$destroy=a}$on(e,n){if(!A(n))return a;const o=this.$$.callbacks[e]||(this.$$.callbacks[e]=[]);return o.push(n),()=>{const r=o.indexOf(n);r!==-1&&o.splice(r,1)}}$set(e){this.$$set&&!C(e)&&(this.$$.skip_bound=!0,this.$$set(e),this.$$.skip_bound=!1)}}function V(t){let e;return{c(){e=M("h2"),e.textContent="Nothing",B(e,"class","nav-tab-wrapper")},m(n,o){q(n,e,o)},p:a,i:a,o:a,d(n){n&&L(e)}}}class W extends U{constructor(e){super(),T(this,e,null,V,j,{})}}new W({target:document.querySelector("#ngt-settings-svelte")});