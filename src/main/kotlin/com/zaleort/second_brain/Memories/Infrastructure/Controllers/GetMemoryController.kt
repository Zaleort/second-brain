package com.zaleort.second_brain.Memories.Infrastructure.Controllers

import com.zaleort.second_brain.Memories.Application.UseCases.GetMemory.GetMemoryCommand
import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Memories.Application.UseCases.GetMemory.GetMemoryHandler
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.PathVariable
import org.springframework.web.bind.annotation.RestController

@RestController
class GetMemoryController(var handler: GetMemoryHandler) {
    @GetMapping("/api/v1/memories/{id}")
    fun createMemory(
        @PathVariable id: String,
        @AuthenticationPrincipal user: UserDetails,
    ): ResponseEntity<MemoryDTO> {
        val userId = user.username
        val memoryDTO = handler.execute(GetMemoryCommand(
            id,
            userId,
        ))
        return ResponseEntity(memoryDTO, HttpStatus.OK)
    }
}