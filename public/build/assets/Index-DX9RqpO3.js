import{T as f,f as r,a,u as n,w as o,F as p,o as d,Z as h,b as t,i as x,d as m,l as _,t as l,n as y}from"./app-BA8Cp2I4.js";import{_ as b}from"./AuthenticatedLayout-B7Gd2BXE.js";import{_ as v}from"./Pagination-DNXFaOWS.js";const w={class:"py-12"},k={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},A={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},C={class:"p-6 bg-white border-b border-gray-200"},N={class:"flex justify-between mb-6"},U={class:"min-w-full divide-y divide-gray-200"},j={class:"bg-white divide-y divide-gray-200"},B={class:"px-6 py-4 whitespace-nowrap"},E={class:"px-6 py-4 whitespace-nowrap"},T={class:"px-6 py-4 whitespace-nowrap"},V={class:"px-6 py-4 whitespace-nowrap text-sm font-medium"},$=["onClick"],S={__name:"Index",props:{users:Object},setup(c){const u=f({}),g=i=>{u.patch(route("users.toggle-active",i))};return(i,e)=>(d(),r(p,null,[a(n(h),{title:"Managemen User"}),a(b,null,{header:o(()=>e[0]||(e[0]=[t("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Manajemen User",-1)])),default:o(()=>[t("div",w,[t("div",k,[t("div",A,[t("div",C,[t("div",N,[e[2]||(e[2]=t("h3",{class:"text-2xl font-semibold"},"Users",-1)),a(n(x),{href:i.route("users.create"),class:"px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"},{default:o(()=>e[1]||(e[1]=[m(" Tambah User ")])),_:1},8,["href"])]),t("table",U,[e[4]||(e[4]=t("thead",{class:"bg-gray-50"},[t("tr",null,[t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Nama"),t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Email"),t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Status"),t("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},"Aksi")])],-1)),t("tbody",j,[(d(!0),r(p,null,_(c.users.data,s=>(d(),r("tr",{key:s.id},[t("td",B,l(s.name),1),t("td",E,l(s.email),1),t("td",T,[t("span",{class:y(["px-2 py-1 rounded-full text-xs",s.is_active?"bg-green-100 text-green-800":"bg-red-100 text-red-800"])},l(s.is_active?"Active":"Inactive"),3)]),t("td",V,[a(n(x),{href:i.route("users.edit",s.id),class:"text-indigo-600 hover:text-indigo-900 mr-2"},{default:o(()=>e[3]||(e[3]=[m("Edit")])),_:2},1032,["href"]),t("button",{onClick:D=>g(s.id),class:"text-sm text-blue-600 hover:text-blue-900"},l(s.is_active?"Deactivate":"Activate"),9,$)])]))),128))])]),a(v,{class:"mt-6",links:c.users.links},null,8,["links"])])])])])]),_:1})],64))}};export{S as default};
