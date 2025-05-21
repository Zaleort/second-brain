package com.zaleort.second_brain.Memories.Infrastructure.Controllers

import com.zaleort.second_brain.Memories.Application.UseCases.CreateMemory.CreateMemoryCommand
import com.zaleort.second_brain.Memories.Application.UseCases.CreateMemory.CreateMemoryHandler
import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import org.springframework.http.ResponseEntity
import org.springframework.web.bind.annotation.PostMapping
import org.springframework.web.bind.annotation.RequestBody
import org.springframework.web.bind.annotation.RestController

@RestController
class CreateMemoryController(val handler: CreateMemoryHandler) {
    @PostMapping("/api/v1/memories")
    fun createMemory(
        @RequestBody command: CreateMemoryCommand,
    ): ResponseEntity<MemoryDTO> {
        return ResponseEntity(
            handler.execute(command),
            org.springframework.http.HttpStatus.CREATED,
        )
    }
}