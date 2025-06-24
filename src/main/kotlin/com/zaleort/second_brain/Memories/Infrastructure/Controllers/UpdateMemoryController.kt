package com.zaleort.second_brain.Memories.Infrastructure.Controllers

import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Memories.Application.UseCases.UpdateMemory.UpdateMemoryCommand
import com.zaleort.second_brain.Memories.Application.UseCases.UpdateMemory.UpdateMemoryHandler
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.PathVariable
import org.springframework.web.bind.annotation.PutMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController

@RestController
class UpdateMemoryController(val handler: UpdateMemoryHandler) {
    @PutMapping("/api/v1/memories/{id}")
    fun updateMemory(
        @PathVariable id: String,
        @RequestBody request: UpdateMemoryRequest,
        @AuthenticationPrincipal user: UserDetails,
    ): ResponseEntity<MemoryDTO> {
        val command = UpdateMemoryCommand(
            id = id,
            userId = user.username,
            title = request.title,
            content = request.content,
            type = request.type,
            tags = request.tags,
        )
        return ResponseEntity(
            handler.execute(command),
            HttpStatus.OK,
        )
    }
}

data class UpdateMemoryRequest(
    val title: String,
    val content: String,
    val type: Int,
    val tags: List<String>,
)