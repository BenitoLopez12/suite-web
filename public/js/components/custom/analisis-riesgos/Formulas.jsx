import React from 'react'
import { BtnIcon } from "../../common/Buttons"
import { InputSimple, InputSimpleDisabled } from "../../common/Inputs"

export const RecordFormulas = ({formulas, handleChangeStatus, handleChangeTitle ,deleteFormula}) => {
    return(
        <div style={{marginTop:"39.5px"}}>
        {
                formulas.map((item,index)=>{
                    return(
                        <React.Fragment key={index}>
                            <RecordFormula item={item} handleChangeTitle={handleChangeTitle} handleChangeStatus={handleChangeStatus} deleteFormula={deleteFormula}/>
                        </React.Fragment>
                    )
                })
            }
        </div>
    )
 }

const RecordFormula = ({item, handleChangeStatus, handleChangeTitle,deleteFormula}) => {
    const changeTitle = (newValue) =>{
        handleChangeTitle(item.id, newValue);
    }
    return(
        <div className="row d-flex align-items-center ">
                            <div className="col-5 col-sm-2 d-flex align-items-center flex-column">
                                <label htmlFor={`riesgo-${item.id}`} >Define el Riesgo</label>
                                <div className="form-group pl-0 anima-focus">
                                    <input
                                    style={{width: "24px", height:"24px"}}
                                        type="checkbox"
                                        className="form-control"
                                        name={`riesgo-${item.id}`}
                                        checked={item.riesgo}
                                        onChange={(e)=>handleChangeStatus(item.id)}
                                    />
                                </div>
                            </div>
                            <div className="col-6 col-sm-3 d-flex flex-column">
                                <label htmlFor={`title-${item.id}`}>Nombre</label>
                                <InputSimple title={""} name={`title-${item.id}`} value={item.title} handleChange={changeTitle} />
                            </div>
                            <div className="col-10 col-sm-6 d-flex flex-column">
                                <label htmlFor={`formulate${item.id}`}>Formula</label>
                                <InputSimpleDisabled title={""} name={`formulate-${item.id}`} value={item.formula} handleChange={null} />
                            </div>
                            <div className="col-2 col-sm-1 d-flex">
                                <BtnIcon icon="delete" onClick={()=>deleteFormula(item.id)}/>
                            </div>
                        </div>
    )
}