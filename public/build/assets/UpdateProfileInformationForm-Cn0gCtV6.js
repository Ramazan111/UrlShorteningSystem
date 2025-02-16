import{y as g,C as x,f as n,o as r,b as a,g as c,a as o,u as t,i as V,e as m,w as u,P as _,p as b,T as k,d as w}from"./app-BabnOOOD.js";import{_ as p,a as v,b as y}from"./TextInput-BaRhaV7s.js";import{P as h}from"./PrimaryButton-D2_8OaK9.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const P={key:0},S={class:"mt-2 text-sm text-gray-800"},B={class:"mt-2 text-sm font-medium text-green-600"},N={class:"flex items-center gap-4"},C={key:0,class:"text-sm text-gray-600"},q={__name:"UpdateProfileInformationForm",props:{mustVerifyEmail:{type:Boolean},status:{type:String}},setup(d){const l=g().props.auth.user,s=x({name:l.name,email:l.email});return(f,e)=>(r(),n("section",null,[e[6]||(e[6]=a("header",null,[a("h2",{class:"text-lg font-medium text-gray-900"}," Profile Information "),a("p",{class:"mt-1 text-sm text-gray-600"}," Update your account's profile information and email address. ")],-1)),a("form",{onSubmit:e[2]||(e[2]=w(i=>t(s).patch(f.route("profile.update")),["prevent"])),class:"mt-6 space-y-6"},[a("div",null,[o(p,{for:"name",value:"Name"}),o(v,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:t(s).name,"onUpdate:modelValue":e[0]||(e[0]=i=>t(s).name=i),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),o(y,{class:"mt-2",message:t(s).errors.name},null,8,["message"])]),a("div",null,[o(p,{for:"email",value:"Email"}),o(v,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:t(s).email,"onUpdate:modelValue":e[1]||(e[1]=i=>t(s).email=i),required:"",autocomplete:"username"},null,8,["modelValue"]),o(y,{class:"mt-2",message:t(s).errors.email},null,8,["message"])]),d.mustVerifyEmail&&t(l).email_verified_at===null?(r(),n("div",P,[a("p",S,[e[4]||(e[4]=m(" Your email address is unverified. ")),o(t(_),{href:f.route("verification.send"),method:"post",as:"button",class:"rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"},{default:u(()=>e[3]||(e[3]=[m(" Click here to re-send the verification email. ")])),_:1},8,["href"])]),V(a("div",B," A new verification link has been sent to your email address. ",512),[[b,d.status==="verification-link-sent"]])])):c("",!0),a("div",N,[o(h,{disabled:t(s).processing},{default:u(()=>e[5]||(e[5]=[m("Save")])),_:1},8,["disabled"]),o(k,{"enter-active-class":"transition ease-in-out","enter-from-class":"opacity-0","leave-active-class":"transition ease-in-out","leave-to-class":"opacity-0"},{default:u(()=>[t(s).recentlySuccessful?(r(),n("p",C," Saved. ")):c("",!0)]),_:1})])],32)]))}};export{q as default};
