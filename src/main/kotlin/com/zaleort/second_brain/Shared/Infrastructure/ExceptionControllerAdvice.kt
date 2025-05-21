package com.zaleort.second_brain.Shared.Infrastructure

import com.zaleort.second_brain.Shared.Domain.Error.ErrorMessageDTO
import com.zaleort.second_brain.Shared.Domain.Error.SecondBrainError
import org.springframework.http.ResponseEntity
import org.springframework.web.bind.annotation.ControllerAdvice
import org.springframework.web.bind.annotation.ExceptionHandler

@ControllerAdvice
class ExceptionControllerAdvice {
    @ExceptionHandler
    fun handleSecondBrainError(exception: SecondBrainError): ResponseEntity<ErrorMessageDTO> {
        return ResponseEntity
            .status(exception.status)
            .body(ErrorMessageDTO(exception.message, exception.code))
    }
}