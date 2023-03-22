/*================================================================
	ORC_JS, JavaScript Class Framework
 	version:3.00.71210
	Copyright 2007 by SourceTec Software Co.,LTD
	For more information, see:www.sothink.com
================================================================*/
if(typeof _STNS!="undefined"&&_STNS.EFFECT&&!_STNS.EFFECT.CEffRect){with(_STNS.EFFECT){_STNS.EFFECT.CEffRect=_STNS.Class(_STNS.EFFECT.CEffect);CEffRect.register("EFFECT/CEffect>CEffRect");CEffRect.construct=function(as){this._tTid=0;this._bShow=0;this._iFms=12;this._iDt=50;this._iDx=0;this._iDy=0;this._iDsx=0;this._iDsy=0;this._iX=0;this._iY=0;this._iSX=-1;this._iSY=-1;this._iGid=-1;this._iCurWid=0;this._iCurHei=0;this.iDur=as[3];this._sBdStyle="solid";this._iBdWid=1;this._sBdClr="#999999";with(_STNS.EFFECT.CEffRect){this.fbSet=fbSet;this.fbDel=fbDel;this.fbApply=fbApply;this.fbPlay=fbPlay;this.fbStop=fbStop;this.fbSetStyle=fbSetStyle;this.fbShow=fbShow;this.fbHide=fbHide;}if(as[4]){this.fbSetStyle(as[4]);}};CEffRect.fbSet=function(){var _r=_STNS,e=_r.fdmGetEleById(this.sDmId,this.dmWin),n;if(!e){return false;}if(this._iGid==-1){n=_r.EFFECT.CEffRect._aGlobal.length;_r.EFFECT.CEffRect._aGlobal.push(this);this._iGid=n;}s="<div style="+"'position:absolute;left:0px;top:0px;z-index:1000;font-size:1pt;line-height:1pt;display:none;background:transparent;'"+" id='stEffR_"+this._iGid+"'>"+"</div>";_STNS.fbInsHTML(this.dmWin.document.body,"afterBegin",s);this._iStat=0;return true;};CEffRect.fbDel=function(){this.fbStop();this._iStat=-1;_STNS.EFFECT.CEffRect._aGlobal[this._iGid]=null;return true;};CEffRect.fbApply=function(){var _r=_STNS,e=_r.fdmGetEleById(this.sDmId,this.dmWin);if(!e){return false;}this._iCurWid=_r.fiGetEleWid(e);this._iCurHei=_r.fiGetEleHei(e);this._iDt=Math.floor(this.iDur/this._iFms);this._iDx=Math.round(this._iCurWid/this._iFms);this._iDy=Math.round(this._iCurHei/this._iFms);e=_r.fdmGetEleById("stEffR_"+this._iGid,this.dmWin);e.style.borderStyle=this._sBdStyle;e.style.borderWidth=this._iBdWid+"px";e.style.borderColor=this._sBdClr;if(!_r.EFFECT.CEffRect._aGlobal[this._iGid]){_r.EFFECT.CEffRect._aGlobal[this._iGid]=this;}this._iStat=1;return true;};CEffRect.fbPlay=function(){if(this._iStat!=1){return false;}if(this._bShow){this.fbShow();}else{this.fbHide();}this._iStat=2;return true;};CEffRect.fbStop=function(){if(this._iStat>0){clearTimeout(this._tTid);var e=_STNS.fdmGetEleById("stEffR_"+this._iGid,this.dmWin);e.style.display="none";e=_STNS.fdmGetEleById(this.sDmId,this.dmWin);e.style.left=this._iX+"px";e.style.top=this._iY+"px";if(this._bShow){e.style.visibility="visible";}else{e.style.visibility="hidden";}this._iStat=0;}return true;};CEffRect.fbSetStyle=function(s){var _r=_STNS,ss;ss=_r.foCss2Style(s);if(ss["visibility"]=="hidden"){this._bShow=0;}else{if(ss["visibility"]=="visible"){this._bShow=1;}}if(ss["left"]){this._iX=parseInt(ss["left"]);}if(ss["top"]){this._iY=parseInt(ss["top"]);}if(ss["borderStyle"]){this._sBdStyle=ss["borderStyle"];}if(ss["borderWidth"]){this._iBdWid=parseInt(ss["borderWidth"]);}if(ss["borderColor"]){this._sBdClr=ss["borderColor"];}if(ss["_stStartX"]){this._iSX=parseInt(ss["_stStartX"]);}else{this._iSX=this._iX+this._iCurWid/2;}if(ss["_stStartY"]){this._iSY=parseInt(ss["_stStartY"]);}else{this._iSY=this._iY+this._iCurHei/2;}this._iDsx=Math.floor((this._iSX-this._iX)/this._iFms);this._iDsy=Math.floor((this._iSY-this._iY)/this._iFms);};CEffRect._aGlobal=[];CEffRect.fbShow=function(t){var _r=_STNS,e=_r.fdmGetEleById("stEffR_"+this._iGid,this.dmWin);if(!t){t=0;}if(t>=this._iFms){e.style.display="none";e=_r.fdmGetEleById(this.sDmId,this.dmWin);e.style.left=this._iX+"px";e.style.top=this._iY+"px";e.style.visibility="visible";this._iStat=0;return true;}else{e.style.width=t*this._iDx+"px";e.style.height=t*this._iDy+"px";e.style.left=this._iSX-t*this._iDsx+"px";e.style.top=this._iSY-t*this._iDsy+"px";this._tTid=setTimeout("_STNS.EFFECT.CEffRect._aGlobal["+this._iGid+"].fbShow("+(++t)+")",this._iDt);}e.style.display="block";};CEffRect.fbHide=function(t){var _r=_STNS,e=_r.fdmGetEleById("stEffR_"+this._iGid,this.dmWin);if(!t){_r.fdmGetEleById(this.sDmId,this.dmWin).style.visibility="hidden";t=0;}if(t>=this._iFms){e.style.display="none";this._iStat=0;return true;}else{e.style.width=Math.max(1,this._iCurWid-t*this._iDx)+"px";e.style.height=Math.max(1,this._iCurHei-t*this._iDy)+"px";e.style.left=this._iX+t*this._iDsx+"px";e.style.top=this._iY+t*this._iDsy+"px";this._tTid=setTimeout("_STNS.EFFECT.CEffRect._aGlobal["+this._iGid+"].fbHide("+(++t)+")",this._iDt);}e.style.display="block";};}}