import{o as f,f as g,r as v,B as $,q as C,C as B,h as D,c as E,a as n,w as r,j as p,D as y,b as s,x as w,n as h,g as S,E as V,p as _,T as U,G as T,d as x,u as d,H as A}from"./app-BA8Cp2I4.js";import{_ as N}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{_ as M,a as O}from"./InputLabel-MjPgU1sP.js";import{_ as P}from"./TextInput-w7EgZHWu.js";const W={},j={class:"inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"};function z(o,l){return f(),g("button",j,[v(o.$slots,"default")])}const b=N(W,[["render",z]]),F={class:"fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0","scroll-region":""},I={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(o,{emit:l}){const a=o,t=l;$(()=>a.show,()=>{a.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const u=()=>{a.closeable&&t("close")},i=m=>{m.key==="Escape"&&a.show&&u()};C(()=>document.addEventListener("keydown",i)),B(()=>{document.removeEventListener("keydown",i),document.body.style.overflow=null});const c=D(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[a.maxWidth]);return(m,e)=>(f(),E(V,{to:"body"},[n(w,{"leave-active-class":"duration-200"},{default:r(()=>[p(s("div",F,[n(w,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:r(()=>[p(s("div",{class:"fixed inset-0 transform transition-all",onClick:u},e[0]||(e[0]=[s("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1)]),512),[[y,o.show]])]),_:1}),n(w,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:r(()=>[p(s("div",{class:h(["mb-6 transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:mx-auto sm:w-full",c.value])},[o.show?v(m.$slots,"default",{key:0}):S("",!0)],2),[[y,o.show]])]),_:3})],512),[[y,o.show]])]),_:3})]))}},K=["type"],L={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup(o){return(l,a)=>(f(),g("button",{type:o.type,class:"inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25"},[v(l.$slots,"default")],8,K))}},q={class:"space-y-6"},G={class:"p-6"},H={class:"mt-6"},J={class:"mt-6 flex justify-end"},Z={__name:"DeleteUserForm",setup(o){const l=_(!1),a=_(null),t=U({password:""}),u=()=>{l.value=!0,T(()=>a.value.focus())},i=()=>{t.delete(route("profile.destroy"),{preserveScroll:!0,onSuccess:()=>c(),onError:()=>a.value.focus(),onFinish:()=>t.reset()})},c=()=>{l.value=!1,t.clearErrors(),t.reset()};return(m,e)=>(f(),g("section",q,[e[6]||(e[6]=s("header",null,[s("h2",{class:"text-lg font-medium text-gray-900"}," Delete Account "),s("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ")],-1)),n(b,{onClick:u},{default:r(()=>e[1]||(e[1]=[x("Delete Account")])),_:1}),n(I,{show:l.value,onClose:c},{default:r(()=>[s("div",G,[e[4]||(e[4]=s("h2",{class:"text-lg font-medium text-gray-900"}," Are you sure you want to delete your account? ",-1)),e[5]||(e[5]=s("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. ",-1)),s("div",H,[n(M,{for:"password",value:"Password",class:"sr-only"}),n(P,{id:"password",ref_key:"passwordInput",ref:a,modelValue:d(t).password,"onUpdate:modelValue":e[0]||(e[0]=k=>d(t).password=k),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:A(i,["enter"])},null,8,["modelValue"]),n(O,{message:d(t).errors.password,class:"mt-2"},null,8,["message"])]),s("div",J,[n(L,{onClick:c},{default:r(()=>e[2]||(e[2]=[x(" Cancel ")])),_:1}),n(b,{class:h(["ms-3",{"opacity-25":d(t).processing}]),disabled:d(t).processing,onClick:i},{default:r(()=>e[3]||(e[3]=[x(" Delete Account ")])),_:1},8,["class","disabled"])])])]),_:1},8,["show"])]))}};export{Z as default};
